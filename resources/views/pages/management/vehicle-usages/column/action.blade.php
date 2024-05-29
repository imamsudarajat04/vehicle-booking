@can('view_usage_history')
  <a href="{!! route('vehicle-usage.off-duty', $item->id) !!}" class="remove-item-btn btn btn-danger">
  <i class="ri-logout-circle-line align-bottom me-2"></i>
      Off Duty
  </a>
@endcan