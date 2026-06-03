@extends('seller.layouts.master')

@section('title', 'Role Permissions')

@section('content')

@php
    use App\Library\Helper;
    $user_role = App\Models\User::getAuthUser()->roles()->first();
@endphp

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('seller.config.role.index')) !!}
        <div class="d-block">
            <h4 class="content-title">ROLE PERMISSIONS</h4>
        </div>

    </div>
    <form action="{{ route('seller.config.role.permission.update', $role->id) }}" method="post">
        @csrf
        <div class="card mb-4 shadow-sm">
            <div class="card-body d-flex justify-content-between" style="padding: .5rem 1.25rem !important">
                    <h4 class="text-capitalize" style="padding-top: 7px"><i class="fas fa-unlock-alt"></i> {{ $role->name }} </h4>
                <div>
                    @if(Helper::hasAuthRolePermission('seller_role_update_permission'))
                        <button type="submit" class="btn btn-sm btn2-secondary submitBt'"><i class="fas fa-save"></i> Save</button>
                    @endif
                </div>
            </div>
        </div>


        <div class="row">
            @foreach($all_permissions as $menu_group => $menu_permissions)
                <div class="col-12">
                    <div class="card mb-3 shadow-sm">
                        <div class="card-body d-flex justify-content-between" style="padding: .5rem 1.25rem !important">
                            <h4 class="text-capitalize"> {{ str_replace('_', ' ', $menu_group) }} Related Permissions </h4>
                        </div>
                    </div>
                </div>
                @foreach($menu_permissions as $group => $permissions)
                    <div class="col-sm-2 mb-4">
                        <div class="card permission-card">
                            <div class="card-header d-inline-flex justify-content-between">
                                <span class="text-capitalize">
                                    {{ str_replace('_', ' ', $group) }}
                                </span>
                                <input class="check-all" type="checkbox">
                            </div>
                            <div class="card-body">
                                @foreach($permissions as $permission)
                                    <div class="form-check">
                                        <input name="permission_ids[]" id="permission_{{ $permission->id }}" class="form-check-input ml-0" type="checkbox" value="{{ $permission->id }}" {{ in_array($permission->id, $role_permissions) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="permission_{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
    </form>
</div>

@stop

@push('scripts')
    <script>
        $(document).ready(function (){
            $("input[type='checkbox'].check-all").click(function(){
                let t = $(this);
                if(t.prop("checked") == true){
                    t.parents('.card').find(".card-body").find("input[type='checkbox']").prop("checked", true);
                }
                else{
                    t.parents('.card').find(".card-body").find("input[type='checkbox']").prop("checked", false);
                }
            });
            $("input[type='checkbox']:not('.check-all')").click(function (){
                let sub_chks = $(this).parents(".card-body").find("input[type='checkbox']");
                let checked = $(this).parents(".card-body").find("input[type='checkbox']:checked");
                if(sub_chks.length == checked.length)
                    $(this).parents(".card").find(".check-all").prop("checked", true);
                else
                    $(this).parents(".card").find(".check-all").prop("checked", false);
            })
        })

    </script>
@endpush
