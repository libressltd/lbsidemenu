@extends('app')

@section ('contentheader_title')
{{ trans('deeppermission.header.title') }}
@endsection

@section ('sidebar_dp_role')
active
@endsection

@section ('sidebar_dp')
active
@endsection

@section('content')
<div class="row">
	@include("libressltd.deeppermission.sidebox")
	<div class="col-md-6">
		<div class="box box-solid">
			<div class="box-header with-border">
				<h3 class="box-title">
					@if (!isset($role))
					{{ trans('deeppermission.role.add') }}
					@else
					{{ trans('deeppermission.role.edit') }}: {{ $role->name }}
					@endif
				</h3>
			</div>
			<div class="box-body">
				{!! Form::lbAlert() !!}
				@if (!isset($role))
				{!! Form::open(array("url" => "role", "method" => "post")) !!}
				@else
				{!! Form::open(array("url" => "role/$role->id", "method" => "put")) !!}
				@endif
				
				{!! Form::lbText("name", @$role->name, trans('deeppermission.role.name'), trans('deeppermission.role.name_hint'), null, config("deeppermission.CNF_REQUIRE_ANUM")) !!}
				{!! Form::lbText("code", @$role->code, trans('deeppermission.role.code'), trans('deeppermission.role.code_hint'), trans('deeppermission.role.code_note'), config("deeppermission.CNF_REQUIRE_ANUM_AND_POINT")) !!}
				{!! Form::lbSubmit() !!}
				{!! Form::close() !!}
            </div>
		</div>
	</div>
</div>
@endsection