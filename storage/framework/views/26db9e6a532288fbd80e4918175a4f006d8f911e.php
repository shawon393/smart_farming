<div class="modal fade" id="new-address-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo e(translate('New Address')); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-default" role="form" action="<?php echo e(route('addresses.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="p-3">
                        <div class="row">
                            <div class="col-md-2">
                                <label><?php echo e(translate('Address')); ?></label>
                            </div>
                            <div class="col-md-10">
                                <textarea class="form-control mb-3" placeholder="<?php echo e(translate('Your Address')); ?>" rows="2" name="address" required></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label><?php echo e(translate('Country')); ?></label>
                            </div>
                            <div class="col-md-10">
                                <div class="mb-3">
                                    <select class="form-control aiz-selectpicker" data-live-search="true" data-placeholder="<?php echo e(translate('Select your country')); ?>" name="country_id" required>
                                        <option value=""><?php echo e(translate('Select your country')); ?></option>
                                        <?php $__currentLoopData = \App\Models\Country::where('status', 1)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($country->id); ?>"><?php echo e($country->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-2">
                                <label><?php echo e(translate('State')); ?></label>
                            </div>
                            <div class="col-md-10">
                                <select class="form-control mb-3 aiz-selectpicker" data-live-search="true" name="state_id" required>

                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <label><?php echo e(translate('City')); ?></label>
                            </div>
                            <div class="col-md-10">
                                <select class="form-control mb-3 aiz-selectpicker" data-live-search="true" name="city_id" required>

                                </select>
                            </div>
                        </div>

                        <?php if(get_setting('google_map') == 1): ?>
                            <div class="row">
                                <input id="searchInput" class="controls" type="text" placeholder="<?php echo e(translate('Enter a location')); ?>">
                                <div id="map"></div>
                                <ul id="geoData">
                                    <li style="display: none;">Full Address: <span id="location"></span></li>
                                    <li style="display: none;">Postal Code: <span id="postal_code"></span></li>
                                    <li style="display: none;">Country: <span id="country"></span></li>
                                    <li style="display: none;">Latitude: <span id="lat"></span></li>
                                    <li style="display: none;">Longitude: <span id="lon"></span></li>
                                </ul>
                            </div>

                            <div class="row">
                                <div class="col-md-2" id="">
                                    <label for="exampleInputuname">Longitude</label>
                                </div>
                                <div class="col-md-10" id="">
                                    <input type="text" class="form-control mb-3" id="longitude" name="longitude" readonly="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2" id="">
                                    <label for="exampleInputuname">Latitude</label>
                                </div>
                                <div class="col-md-10" id="">
                                    <input type="text" class="form-control mb-3" id="latitude" name="latitude" readonly="">
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <div class="row">
                            <div class="col-md-2">
                                <label><?php echo e(translate('Postal code')); ?></label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control mb-3" placeholder="<?php echo e(translate('Your Postal Code')); ?>" name="postal_code" value="" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label><?php echo e(translate('Phone')); ?></label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control mb-3" placeholder="<?php echo e(translate('+880')); ?>" name="phone" value="" required>
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-sm btn-primary"><?php echo e(translate('Save')); ?></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="edit-address-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo e(translate('New Address')); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body" id="edit_modal_body">

            </div>
        </div>
    </div>
</div>

<?php $__env->startSection('script'); ?>
    <script type="text/javascript">
        function add_new_address(){
            $('#new-address-modal').modal('show');
        }

        function edit_address(address) {
            var url = '<?php echo e(route("addresses.edit", ":id")); ?>';
            url = url.replace(':id', address);
            
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: 'GET',
                success: function (response) {
                    $('#edit_modal_body').html(response.html);
                    $('#edit-address-modal').modal('show');
                    AIZ.plugins.bootstrapSelect('refresh');

                    <?php if(get_setting('google_map') == 1): ?>
                        var lat     = -33.8688;
                        var long    = 151.2195;

                        if(response.data.address_data.latitude && response.data.address_data.longitude) {
                            lat     = response.data.address_data.latitude;
                            long    = response.data.address_data.longitude;
                        }

                        initialize(lat, long, 'edit_');
                    <?php endif; ?>
                }
            });
        }
        
        $(document).on('change', '[name=country_id]', function() {
            var country_id = $(this).val();
            get_states(country_id);
        });

        $(document).on('change', '[name=state_id]', function() {
            var state_id = $(this).val();
            get_city(state_id);
        });
        
        function get_states(country_id) {
            $('[name="state"]').html("");
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "<?php echo e(route('get-state')); ?>",
                type: 'POST',
                data: {
                    country_id  : country_id
                },
                success: function (response) {
                    var obj = JSON.parse(response);
                    if(obj != '') {
                        $('[name="state_id"]').html(obj);
                        AIZ.plugins.bootstrapSelect('refresh');
                    }
                }
            });
        }

        function get_city(state_id) {
            $('[name="city"]').html("");
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "<?php echo e(route('get-city')); ?>",
                type: 'POST',
                data: {
                    state_id: state_id
                },
                success: function (response) {
                    var obj = JSON.parse(response);
                    if(obj != '') {
                        $('[name="city_id"]').html(obj);
                        AIZ.plugins.bootstrapSelect('refresh');
                    }
                }
            });
        }
    </script>

    
    <?php if(get_setting('google_map') == 1): ?>
        <?php echo $__env->make('frontend.partials.google_map', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?><?php /**PATH C:\xampp\htdocs\Farming_solution\resources\views/frontend/partials/address_modal.blade.php ENDPATH**/ ?>