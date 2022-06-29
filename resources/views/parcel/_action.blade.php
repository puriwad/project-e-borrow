<div class="btn-group">
	<button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown"
		aria-expanded="false">
		<span class="sr-only">Toggle Dropdown</span>
	</button>
	<div class="dropdown-menu" role="menu" style="">
		<a class="dropdown-item" href="{{ route('parcel.edit', $id) }}">แก้ไขข้อมูล</a>
		<a class="dropdown-item" href="{{ route('parcelstock.index', $id) }}">คลังพัสดุ</a>
		@switch($statusId)
			@case(App\Models\ParcelStatus::Active)
				<a class="dropdown-item text-warning" href="javascript:;" data-action="status"
					data-form="status-form-{{ $id }}" data-input="statusId-input-{{ $id }}"
					data-value="{{ App\Models\ParcelStatus::Inactive }}"
					data-color="#ffc107" data-label="ปิดไม่ให้เบิก" onclick="fncAction(this)">ปิดไม่ให้เบิก</a>
			@break

			@case(App\Models\ParcelStatus::Inactive)
				<a class="dropdown-item text-success" href="javascript:;" data-action="status"
					data-form="status-form-{{ $id }}" data-input="statusId-input-{{ $id }}"
					data-value="{{ App\Models\ParcelStatus::Active }}"
					data-color="#28a745" data-label="เบิกได้" onclick="fncAction(this)">เบิกได้</a>
			@break
		@endswitch
		<div class="dropdown-divider"></div>
		<a class="dropdown-item text-danger" href="javascript:;" data-action="delete"
			data-form="delete-form-{{ $id }}"
			data-color="#dc3545" data-label="ลบข้อมูล" onclick="fncAction(this)">ลบข้อมูล</a>
	</div>
</div>
<form id="status-form-{{ $id }}" method="post" action="{{ route('parcel.update', $id) }}">
	@csrf
	@method('PUT')
	<input type="hidden" id="statusId-input-{{ $id }}" name="statusId" value="">
	<input type="hidden" id="updated_userId_{{ $id }}" name="updated_userId" value="{{ Auth::user()->id }}">
	<input type="hidden" id="updated_at_{{ $id }}" name="updated_at" value="{{ Carbon\Carbon::now(); }}">
</form>
<form id="delete-form-{{ $id }}" method="post" action="{{ route('parcel.destroy', $id) }}">
	@csrf
	@method('DELETE')
</form>
