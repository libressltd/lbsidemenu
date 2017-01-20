@extends('app')

@section ('contentheader_title')
{{ trans('deeppermission.header.title') }}
@endsection

@section ('sidebar_dp_permission_group')
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
					@if (!isset($group))
					{{ trans('deeppermission.group.add') }}
					@else
					{{ trans('deeppermission.group.edit') }}: {{ $group->name }}
					@endif
				</h3>
			</div>
			<div class="box-body">
				{!! Form::lbAlert() !!}
				@if (!isset($group))
				{!! Form::open(array("url" => "permission/group", "method" => "post")) !!}
				@else
				{!! Form::open(array("url" => "permission/group/$group->id", "method" => "put")) !!}
				@endif
				
				{!! Form::lbText("name", @$group->name, trans('deeppermission.group.name'), trans('deeppermission.group.name_hint'), null, config("deeppermission.CNF_REQUIRE_ANUM")) !!}
				{!! Form::lbText("code", @$group->code, trans('deeppermission.group.code'), trans('deeppermission.group.code_hint'), trans('deeppermission.group.code_note'), config("deeppermission.CNF_REQUIRE_ANUM_AND_POINT")) !!}
				{!! Form::lbSubmit() !!}
				{!! Form::close() !!}
            </div>
		</div>
	</div>
</div>
@endsection