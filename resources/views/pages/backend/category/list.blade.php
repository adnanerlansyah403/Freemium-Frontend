@extends('homepage')

@section('content')
  <div x-data="admin">
    <div x-init="checkSession()"></div>
    <template x-if="isLogedIn">
      <div x-data="admin" class="text-center mb-[100px] mt-5">
        <h1>Welcome admin!</h1>
      </div>
    </template>
  </div>
@endsection