<!DOCTYPE html>
<html lang="en">

@section('htmlheader')
	@include('sk.layouts.partials.htmlheader')
@show
<body class="{{ SKConfigs::getByKey('skin') }} {{ SKConfigs::getByKey('layout') }} @if(SKConfigs::getByKey('layout') == 'sidebar-mini') sidebar-collapse @endif" bsurl="{{ url('') }}" adminRoute="{{ config('skato-admin.adminRoute') }}">
<div class="wrapper">

	@include('sk.layouts.partials.mainheader')

	@if(SKConfigs::getByKey('layout') != 'layout-top-nav')
		@include('sk.layouts.partials.sidebar')
	@endif

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		@if(SKConfigs::getByKey('layout') == 'layout-top-nav') <div class="container"> @endif
		@if(!isset($no_header))
			@include('sk.layouts.partials.contentheader')
		@endif
		
		<!-- Main content -->
		<section class="content {{ $no_padding or '' }}">
			<!-- Your Page Content Here -->
			@yield('main-content')
		</section><!-- /.content -->

		@if(SKConfigs::getByKey('layout') == 'layout-top-nav') </div> @endif
	</div><!-- /.content-wrapper -->

	@include('sk.layouts.partials.controlsidebar')

	@include('sk.layouts.partials.footer')

</div><!-- ./wrapper -->

@include('sk.layouts.partials.file_manager')

@section('scripts')
	@include('sk.layouts.partials.scripts')
@show

</body>
</html>
