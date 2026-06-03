@extends('seller.pages.member.layout.master')

@section('title', 'Client Address')

@section('clientContent')
    <div class="" id="emergency_contact_show">
    @include('seller.pages.address.index')
    </div>
    <div class="d-none" id="emergency_contact_edit">
    @include('seller.pages.address.edit')
    </div>
@endsection