@extends('administrator.master')
@section('headtitle', 'Garden Pages | Dashboard')
@section('main_content')
<dashboardadmin url="{{ url('/cp') }}" />
@endsection
