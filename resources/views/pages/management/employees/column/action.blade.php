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
        @can('edit_employees')
          <li>
            <a class="dropdown-item edit-item-btn" href="{!! route('employee.edit', $item->id) !!}"
              ><i
              class="ri-pencil-fill align-bottom me-2 text-muted"
              ></i>
              Edit
            </a>
          </li>
        @endcan
        @can('delete_employees')
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