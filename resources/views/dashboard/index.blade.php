@php
  if(auth()->user()->is_admin) {
      echo redirect()->route('admin.dashboard')->send();
  }
@endphp
{{-- Fan dashboard inline --}}
@extends('layouts.app')
@section('title','My Dashboard')
@section('content')
  @include('dashboard.user')
@endsection
