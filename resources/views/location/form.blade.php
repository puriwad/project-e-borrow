@extends('layouts.bo')
@if (!empty($breadcrumb))
	@section('title', $breadcrumb[count($breadcrumb) - 1]['name'])
	@section('breadcrumb')
		@include('layouts._breadcrumb', ['breadcrumb' => $breadcrumb])
	@endsection
@endif
@section('content')
	@if (empty($location))
		{{ Form::open(['novalidate', 'route' => 'location.store', 'class' => $errors->any() ? 'was-validated form-horizontal' : 'needs-validation form-horizontal', 'id' => 'account-form', 'method' => 'post', 'files' => true]) }}
	@else
		{{ Form::model($location, ['novalidate', 'route' => ['location.update', $location->id], 'class' => $errors->any() ? 'was-validated form-horizontal' : 'needs-validation form-horizontal', 'id' => 'account-form', 'method' => 'put', 'files' => true]) }}
	@endif
	<div class="card">
		<div class="card-body">
			<div class="row">
				<div class="col-sm-6">
					<label class="col-sm-12 col-form-label"><span class="text-danger">*</span>ชื่อ:</label>
					<div class="col-sm-12">
						<div class="form-group">
							{{ Form::text('name', old('name'), ['class' => 'form-control', 'required', 'placeholder' => 'กรุณากรอกชื่อ']) }}
							@error('name')
								<small class="text-danger">{{ $message }}</small>
							@enderror
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<label class="col-sm-12 col-form-label"><span class="text-danger">*</span>สาขาวิชา
						:</label>
					<div class="col-sm-12">
						<div class="form-group">
							{{ Form::select('departmentId', $department, old('departmentId'), ['id' => 'departmentId', 'required', 'class' => 'form-control']) }}
							@error('departmentId')
								<small class="text-danger">{{ $message }}</small>
							@enderror
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="card-footer">
			<div class="row">
				<div class="col-6 col-sm-6">
					<button type="reset" class="btn btn-secondary">ล้างข้อมูล</button>
				</div>
				<div class="col-6 col-sm-6">
					<button type="submit" class="btn btn-success float-right" name="action"
						value="save">บันทึกข้อมูล</button>
				</div>
			</div>
		</div>
	</div>
	{!! Form::close() !!}
@endsection
