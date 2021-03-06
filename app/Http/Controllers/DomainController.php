<?php

namespace App\Http\Controllers;

use App\Exports\DomainExport;
use App\Models\Domain;
use App\Models\Platform;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Redirect;
use Whois;

class DomainController extends Controller
{

    protected $protocols = [
        'http',
        'https',
    ];

    public function index()
    {
        $fields = [
            '__checkbox' => [
                'name' => '__checkbox',
                'titleClass' => 'center aligned',
                'dataClass' => 'center aligned',
            ],
            'id' => 'id',
            'platform_name' => 'platform',
            'hostname' => 'main_domain',
            'name' => 'domain',
            'protocols' => 'protocol',
            // 'usage' => 'usage',
            // 'backup' => 'backup',
            'enable' => 'enable',
            'status_code' => 'status_code',
            'remark' => 'remark',
            'expired_at' => 'expired_at',
            'deleted_at' => 'deleted_at',
            'actions' => 'operation',
        ];

        if (Request::wantsJson()) {
            return Domain::leftjoin('platforms', 'domains.platform_id', '=', 'platforms.id')
                ->select('domains.*', 'platforms.name as platform_name')
                ->sort(Request::get('sort'))
                ->filter(Request::only('search', 'trashed', 'expired', 'status'))
                ->paginate()
                ->merge([
                    'problem' => Domain::leftjoin('platforms', 'domains.platform_id', '=', 'platforms.id')
                        ->filter(Request::only('search', 'trashed', 'expired', 'status'))
                        ->selectRaw('sum(case when (json_extract(domains.http, "$.http.Status_code") < 400 OR json_extract(domains.http, "$.https.Status_code") < 400) then 0 else 1 end) as problem')
                        ->first()->problem,
                ])
                ->only(...array_keys($fields));
        }
        return Inertia::render('Domains/Index', [
            'filters' => Request::all('search', 'trashed'),
            'fields' => $this->getDataTableFields($fields, ['actions', 'hostname'], ['deleted_at', 'id']),
        ]);
    }

    public function create()
    {
        return Inertia::render('Domains/Create', [
            'platforms' => Platform::all()->transform(function ($platform) {
                return [
                    'label' => $platform->name,
                    'code' => $platform->id,
                ];
            }),
            'protocols' => $this->protocols,
        ]);
    }

    public function store()
    {
        $names = explode(',', Request::validate([
            'names' => ['required'],
        ])['names']);
        foreach ($names as $name) {
            $validator = Validator::make([
                'name' => $name,
            ], [
                'name' => ['required', 'unique:domains', 'max:100'],
            ], [
                'name.unique' => __('validation.unique', ['attribute' => $name]),
            ]);

            if ($validator->fails()) {
                return Redirect::back()
                    ->withErrors($validator)
                    ->withInput();
            }
            Domain::create(
                array_merge(
                    Request::validate([
                        'protocols' => ['required', 'array'],
                        'backup' => ['required', 'boolean'],
                        'renew' => ['required', 'boolean'],
                        'enable' => ['required', 'boolean'],
                        'platform_id' => ['required', 'numeric'],
                        'remark' => ['string'],
                    ]),
                    [
                        'name' => $name,
                        'expired_at' => Whois::getInfo($name)['expired_at'] ?? null,
                    ]
                )
            );
        }
        return Redirect::route('domains.index')
            ->with('success', __('all.create_success', [
                'name' => __('all.domain'),
            ]));
    }

    public function edit(Domain $domain)
    {
        return Inertia::render('Domains/Edit', [
            'domain' => $domain->only('id', 'name', 'protocols', 'backup', 'renew', 'enable', 'remark', 'platform_id'),
            'platforms' => Platform::all()->transform(function ($platform) {
                return [
                    'label' => $platform->name,
                    'code' => $platform->id,
                ];
            }),
            'protocols' => $this->protocols,
        ]);
    }
    public function update(Domain $domain)
    {
        if (Request::get('platform_id') == null) {
            Request::merge([
                'platform_id' => 0,
            ]);
        } else if (Request::get('platform_id') == -1) {
            Request::offsetUnset('platform_id');
        } else {
            Request::validate([
                'platform_id' => 'exists:platforms,id',
            ]);
        }
        $domain->update(
            Request::validate([
                'name' => ['nullable', "unique:domains,name,{$domain->id}", 'max:100'],
                'protocols' => ['nullable', 'array'],
                'backup' => ['nullable', 'boolean'],
                'renew' => ['nullable', 'boolean'],
                'enable' => ['nullable', 'boolean'],
                'platform_id' => ['nullable', 'numeric'],
                'remark' => ['nullable', 'string'],
            ])
        );
        if (Request::wantsJson()) {
            return $domain;
        }
        return Redirect::back()
            ->with('success', __('all.edit_success', [
                'name' => __('all.domain'),
            ]));
    }

    public function restore(Domain $domain)
    {
        if ($domain->trashed()) {
            $domain->restore();
        }

        if (Request::wantsJson()) {
            return response()->json(null);
        }
        return Redirect::back()
            ->with('success', __('all.restore_success', [
                'name' => __('all.domain'),
            ]))
            ->withInput();
    }

    public function destroy(Domain $domain)
    {
        if ($domain->trashed()) {
            $domain->forceDelete();
        } else {
            $domain->delete();
        }
        if (Request::wantsJson()) {
            return response()->json(null);
        }
        return Redirect::back()
            ->with('success', __('all.delete_success', [
                'name' => __('all.domain'),
            ]))
            ->withInput();
    }

    public function export()
    {
        return new DomainExport();
    }

    public function massDestroy()
    {
        $ids = Request::validate([
            'ids' => ['required', 'array'],
        ])['ids'];
        Domain::whereIn('id', $ids)->where('deleted_at', '!=', null)->forceDelete();
        Domain::whereIn('id', $ids)->delete();
        if (Request::wantsJson()) {
            return response()->json(null);
        }
        return Redirect::back()
            ->with('success', __('all.delete_success', [
                'name' => __('all.domain'),
            ]))
            ->withInput();
    }

}
