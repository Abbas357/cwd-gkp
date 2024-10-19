<div class="action-btns">
    @if(!empty($image))
        <img src="{{ $image }}" class="rounded" style="height:100px; width:60px" alt="Image">
    @else
        <img src="{{ asset('admin/images/no-image.jpg') }}" class="rounded" style="height:60px; width:60px" alt="No Image">
    @endif
</div>
