@extends('layouts.bo')
@if (!empty($breadcrumb))
	@section('title', $breadcrumb[count($breadcrumb) - 1]['name'])
	@section('breadcrumb')
		@include('layouts._breadcrumb', ['breadcrumb' => $breadcrumb])
	@endsection
@endif
@section('css')
	<!-- DataTables -->
	<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('content')
	<div class="card">
		<div class="card-body">
			<div class="row">
				<div class="col-md-3">
                    <input type="hidden" name="parcelId" id="parcelId" value="{{ $parcel->id }}">
					<select name="typeId" id="typeId" class="form-control form-control-border border-width-2"
						onchange="loadFilter(this)">
						<option value="">ประเภทรายการ</option>
						@foreach ($stocktype as $key => $value)
							<option value="{{ $value->id }}">{{ $value->name }}</option>
						@endforeach
					</select>
				</div>
			</div>
		</div>
	</div>
	<div class="card">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table-hover table-bordered table"
					id="data-table"
					width="100%"
					data-url="{{ route('parcelstock.jsontable') }}"
					data-create="{{ route('parcelstock.create', $parcel->id) }}">
					<thead>
						<tr>
							<th>ลำดับ</th>
							<th>ประเภทรายการ</th>
							<th>จำนวน</th>
							<th>เพิ่มข้อมูล</th>
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection

@section('javascript')
	<!-- DataTables  & Plugins -->
	<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
	<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
	<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
	<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
	<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
	<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
	<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
	<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

	<script>
	 var DataTable = $('#data-table').DataTable({
	  autoWidth: false,
	  responsive: true,
	  lengthChange: false,
	  processing: true,
	  serverSide: true,
	  destroy: true,
	  paging: true,
	  pageLength: 10,
	  language: {
	   search: 'ค้นหา',
	   processing: '<i class="fa fa-spinner fa-spin fa-lg"></i><span class="ml-2">กำลังโหลดข้อมูล...</span> ',
	   info: "แสดง หน้า _PAGE_ จาก _PAGES_",
	   infoEmpty: "",
	   zeroRecords: "ไม่พบข้อมูล",
	   infoFiltered: "(ค้นหา จาก _MAX_ รายการ)",
	   paginate: {
	    first: '<i class="fas fa-angle-double-left"></i>',
	    last: '<i class="fas fa-angle-double-right">',
	    next: '<i class="fas fa-angle-right"></i>',
	    previous: '<i class="fas fa-angle-left"></i>'
	   },
	  },
	  dom: "<'row'<'col-sm-6 col-md-6'Bl><'col-sm-6 col-md-6'>>" +
	   "<'row'<'col-sm-12'tr>>" +
	   "<'row'<'col-sm-6 col-md-6'i><'col-sm-6 col-md-6'p>>",
	  buttons: [{
	   text: '<i class="fa fa-plus"></i>&nbsp;&nbsp;เพิ่มข้อมูล',
	   className: 'btn-flat btn-outline-success',
	   init: function(api, node, config) {
	    $(node).removeClass('btn-secondary')
	   },
	   action: function(e, dt, node, config) {
	    location.href = $('#data-table').attr('data-create');
	   }
	  }],
	  ajax: {
	   url: $('#data-table').attr('data-url'),
	   type: "GET",
	   data: function(d) {
	    d.parcelId = $('#parcelId').val();
	   },
	  },
	  ordering: false,
	  columnDefs: [{
	    'targets': [0],
	    'width': '5%',
	    'className': 'text-center',
	   },
	   {
	    'targets': [1],
	   },
	   {
	    'targets': [2],
	    'width': '10%',
        'className': 'text-center',
	   },
	   {
	    'targets': [3],
	    'width': '10%',
	    'className': 'text-center',
	   },
	  ],
	  columns: [{
	    data: 'DT_RowIndex'
	   },
	   {
	    data: 'parcel_stock_type.name'
	   },
	   {
	    data: 'stock'
	   },
	   {
	    data: 'created_at'
	   }
	  ]
	 });
	</script>

	<script>
	 function loadFilter(e) {
	  DataTable.ajax.reload();
	 }

	 function fncAction(e) {
	  let action = $(e).attr('data-action');
	  let input = $(e).attr('data-input');
	  let value = $(e).attr('data-value');
	  let form = $(e).attr('data-form')
	  let color = $(e).attr('data-color')
	  let label = $(e).attr('data-label')

	  Swal.fire({
	   title: 'คุณแน่ใจไหม?',
	   text: "เมื่อยืนยันแล้วคุณจะไม่สามารถเปลี่ยนกลับได้!",
	   icon: 'warning',
	   showCancelButton: true,
	   confirmButtonColor: color,
	   cancelButtonColor: '#6c757d',
	   confirmButtonText: label,
	   cancelButtonText: 'ยกเลิก'
	  }).then((result) => {
	   if (result.value) {
	    console.log(value);
	    switch (action) {
	     case "status":
	      $('#' + input).val(value);
	      $('#' + form).submit();
	      break;
	     default:
	      $('#' + form).submit();
	      break;
	    }
	   }
	  }).catch(swal.noop);
	 }
	</script>
@endsection