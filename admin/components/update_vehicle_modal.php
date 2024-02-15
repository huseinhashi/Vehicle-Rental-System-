<!-- Update Vehicle Modal -->
<div class="modal fade" id="updateVehicleModal" tabindex="-1" role="dialog" aria-labelledby="updateVehicleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateVehicleModalLabel">Update Vehicle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Update Vehicle Form -->
                <form id="updateVehicleForm" enctype="multipart/form-data">
                    <input type="hidden" id="updateVehicleId" name="vehicle_id" />

                    <!-- Brand -->
                    <div class="form-group">
                        <label for="updateBrand">Brand:</label>
                        <input type="text" class="form-control" id="updateBrand" name="update_brand" required>
                    </div>

                    <!-- Model -->
                    <div class="form-group">
                        <label for="updateModel">Model:</label>
                        <input type="text" class="form-control" id="updateModel" name="update_model" required>
                    </div>

                    <!-- Year -->
                    <div class="form-group">
                        <label for="updateYear">Year:</label>
                        <input type="number" class="form-control" id="updateYear" name="update_year" required>
                    </div>

                    <!-- Price -->
                    <div class="form-group">
                        <label for="updatePrice">Price:</label>
                        <input type="number" class="form-control" id="updatePrice" name="update_price" required>
                    </div>

                    <!-- Availability -->

                    <div class="form-group">

                        <label for="updateAvailability">Availability:</label>
                        <select class="form-control" id="updateAvailability" name="update_availability" required>
                            <option value="available">Available</option>
                            <option value="unavailable">Unavailable</option>
                        </select>
                    </div>

                    <!-- Image -->
                    <div class="form-group">
                        <label for="updateImage">Update Image:</label>
                        <input type="file" class="form-control-file" id="updateImage" name="update_image">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveChangesBtn">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>