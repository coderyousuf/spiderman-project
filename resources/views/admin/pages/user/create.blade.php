@extends('admin.layouts.master')
@section('page_title', 'User Create')
@push('admin_style')

@endpush
@section('admin_content')

<div class="row">
    <div class="col">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">User Create Form</h5>
                <small class="text-muted float-end">

                    <a href="{{ route('users.index') }}" class="btn btn-secondary"><i class='bx bx-arrow-back'></i> Back to users</a>
                </small>
              </div>
              <div class="card-body">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Role Selection</label>
                        <select name="role_id" id="" class="form-select @error('role_id') is-invalid @enderror">
                            <option value="">Select A Role</option>
                            @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                            @endforeach

                        </select>
                        @error('module_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                  <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Users Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="basic-default-fullname" placeholder="Enter a userss name">
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                  <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Users Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="basic-default-fullname" placeholder="Enter a users Email">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                  <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Users Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="basic-default-fullname" placeholder="Enter a users Password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                  <button type="submit" class="btn btn-primary">Send</button>
                </form>
              </div>
        </div>
    </div>
</div>

@endsection
@push('admin_script')

@endpush
