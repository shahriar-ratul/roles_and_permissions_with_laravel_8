<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>

<script src="{{asset('js/sweetalert2@10.js')}}"></script>

<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>

<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

@yield('scripts')
@stack('js')

