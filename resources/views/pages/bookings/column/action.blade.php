<td>
  <div class="dropdown d-inline-block">
    <button
        class="btn btn-soft-secondary btn-sm dropdown"
        type="button"
        data-bs-toggle="dropdown"
        aria-expanded="false"
    >
        <i class="ri-more-fill align-middle"></i>
    </button>
    <ul class="dropdown-menu dropdown-menu-end">
        @can('approve_bookings')
          <li>
            <a class="dropdown-item approval-item-btn" href="{!! route('booking.approve', $item->id) !!}"
              ><i
              class="ri-check-line align-bottom me-2 text-muted"
              ></i>
              Approval
            </a>
          </li>
        @endcan
        @can('reject_bookings')
          <li>
            <a class="dropdown-item reject-item-btn" href="{!! route('booking.reject', $item->id) !!}"
              ><i
              class="ri-close-line align-bottom me-2 text-muted"
              ></i>
              Reject
            </a>
          </li>
        @endcan
        @can('edit_bookings')
          <li>
            <a class="dropdown-item edit-item-btn" href="{!! route('booking.edit', $item->id) !!}"
              ><i
              class="ri-pencil-fill align-bottom me-2 text-muted"
              ></i>
              Edit
            </a>
          </li>
        @endcan
        @can('delete_bookings')
          <li>
            <a href="javascript:void(0);" class="dropdown-item remove-item-btn" id="btn-hapus" data-id="{!! $item->id !!}">
                <i
                class="ri-delete-bin-fill align-bottom me-2 text-muted"
                ></i>
                Delete
            </a>
          </li>
        @endcan
    </ul>
  </div>
</td>