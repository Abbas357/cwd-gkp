<style>
    .table-cell {
        padding: 0.1rem 0.5rem;
        vertical-align: middle;
    }
</style>
<div class="row downloads-details">
    <div class="col-md-12">

        <table class="table table-bordered mt-3">
            <tr>
                <th class="table-cell"> Name</th>
                <td>
                    {{ $comment->name }}
                </td>
            </tr>

            <tr>
                <th class="table-cell"> Email</th>
                <td>
                    {{ $comment->email }}
                </td>
            </tr>
            
            <tr>
                <th class="table-cell">Comment</th>
                <td>
                    {!! $comment->body !!}
                </td>
            </tr>

            <tr>
                <th class="table-cell">On</th>
                <td>
                    {{ class_basename($comment->commentable_type) }}
                </td>
            </tr>
        </table>
    </div>
</div>