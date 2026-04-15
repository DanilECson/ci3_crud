<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Products</h2>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createModal">
            Create Product
        </button>
    </div>

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($products)): ?>
                <?php $rowNumber = 1; ?>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo $rowNumber++; ?></td>
                        <td><?php echo htmlspecialchars($product['title'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($product['description'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary edit-btn" data-toggle="modal" data-target="#editModal"
                                data-id="<?php echo $product['id']; ?>"
                                data-title="<?php echo htmlspecialchars($product['title'], ENT_QUOTES, 'UTF-8'); ?>"
                                data-description="<?php echo htmlspecialchars($product['description'], ENT_QUOTES, 'UTF-8'); ?>">
                                Edit
                            </button>
                            <button type="button" class="btn btn-sm btn-danger delete-btn" data-toggle="modal" data-target="#deleteModal"
                                data-id="<?php echo $product['id']; ?>"
                                data-title="<?php echo htmlspecialchars($product['title'], ENT_QUOTES, 'UTF-8'); ?>">
                                Delete
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">No products found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Create Product Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?php echo site_url('product/create'); ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Create Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="create-title">Name</label>
                        <input type="text" class="form-control" id="create-title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="create-description">Description</label>
                        <textarea class="form-control" id="create-description" name="description" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?php echo site_url('product/update'); ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit-id" name="id">
                    <div class="form-group">
                        <label for="edit-title">Name</label>
                        <input type="text" class="form-control" id="edit-title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-description">Description</label>
                        <textarea class="form-control" id="edit-description" name="description" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Product Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?php echo site_url('product/delete'); ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="delete-id" name="id">
                    <p>Are you sure you want to delete <strong id="delete-product-name"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#editModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var title = button.data('title');
            var description = button.data('description');

            var modal = $(this);
            modal.find('#edit-id').val(id);
            modal.find('#edit-title').val(title);
            modal.find('#edit-description').val(description);
        });

        $('#deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var title = button.data('title');

            var modal = $(this);
            modal.find('#delete-id').val(id);
            modal.find('#delete-product-name').text(title);
        });
    });
</script>
