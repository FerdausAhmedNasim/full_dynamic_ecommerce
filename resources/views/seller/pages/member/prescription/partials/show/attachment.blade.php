<div class="table-responsive">
    <table class="table">
        <thead>
            <tr class="text-center">
                <th>File Name</th>
                <th>File</th>
                <th>Date</th>
                <th>Operator</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($attachments as $attachment)
            <tr class="text-center">
                <td class="p-1">{{ $attachment->name }}</td>

                <td class="p-1">
                    @if(! str_contains($attachment->attachment, '.pdf'))
                    <img src="{{ $attachment->getAttachment() }}" class="img-lg rounded border border-secondary"  alt="profile">
                    @else <i class="far fa-file-pdf icon-lg"></i>@endif
                </td>

                <td class="p-1">{{ getFormattedDateTime($attachment->created_at) }}</td>
                <td class="p-1">{{ $attachment->operator?->full_name }}</td>

                <td class="text-center py-1">
                    <a href="{{ $attachment->getAttachment() }}" target="_blank" class="btn btn-light btn-sm">
                        <i class="ti-eye text-primary"></i> View
                    </a>
                    <a href="{{ $attachment->getAttachment() }}" download class="btn btn-light btn-sm">
                        <i class="ti-download text-danger"></i> Download
                    </a>
                </td>
            </tr>
            @empty
            <p class="text-center">No attachment found</p>
            @endforelse
        </tbody>
    </table>
    <hr>
</div>
