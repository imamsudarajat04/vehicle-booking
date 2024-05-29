<div class="d-flex flex-wrap gap-2">
  @foreach ($item->permissions as $permission)
    <h5><span class="badge rounded-pill bg-info">{!! $permission->name !!}</span></h5>
  @endforeach
</div>