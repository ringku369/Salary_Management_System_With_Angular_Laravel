<!-- Modal [register] -->
<div id="register" class="p-0 modal fade" role="dialog" aria-labelledby="register" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout" role="document">
        <div class="modal-content full">
            <div class="modal-header" data-dismiss="modal">
                Vendor Signup Form <i class="icon-close"></i>
            </div>
            <div class="modal-body">


                <form class="row" id="registerForm" method="post" action="<?php echo e(route('guest.register.store')); ?>">
                    

                   

<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?> ">
        


                    <div class="col-12 p-0 align-self-center">
                        <div class="row">
                            <div class="col-12 p-0 pb-3">
                                <h2>Register</h2>
                                <div class="errorMsg" style="font-size:11px"></div>
                                <div class="successMsg"style="font-size:11px"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 p-0 input-group">
                                <input type="text" name="name" class="form-control" placeholder="Enter Your Full Name" required="required">
                            </div>
                              <div class="col-12 p-0 input-group">
                                <input type="text" name="company" class="form-control" placeholder="Enter Your Company Name" required="required">
                            </div>
                            <div class="col-12 p-0 input-group">
                                <input type="text" name="contact" class="form-control" placeholder="Enter Your Phone No" required="required">
                            </div>
                            <div class="col-12 p-0 input-group">
                                <input type="email" name="email" class="form-control" placeholder="Email" required="required">
                            </div>
                            <div class="col-12 p-0 input-group">
                                <input type="text" name="address" class="form-control" placeholder="Address" required="required">
                            </div>
                              <div class="col-12 p-0 input-group">
                                <input type="text" name="area" class="form-control" placeholder="Coverage Area" required="required">
                            </div>
                             <div class="col-12 p-0 input-group">
                                <textarea name="experience" class="form-control" placeholder="Previous Experience" required="required"></textarea>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-12 p-0 input-group align-self-center">
                                <button class="btn primary-button submitBtn"><i class="icon-rocket"></i>REGISTER
<span style="color:red; display: none;margin-left: 10px;" class="faLoader"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> wait... </span>
                                </button>

                                
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal [responsive menu] -->
<div id="menu" class="p-0 modal fade" role="dialog" aria-labelledby="menu" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout" role="document">
        <div class="modal-content full">
            <div class="modal-header" data-dismiss="modal">
                Menu <i class="icon-close"></i>
            </div>
            <div class="menu modal-body">
                <div class="row w-100">
                    <div class="items p-0 col-12 text-center">
                        <!-- Append [navbar] -->
                    </div>
                    <div class="contacts p-0 col-12 text-center">
                        <!-- Append [navbar] -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scroll [to top] -->
<div id="scroll-to-top" class="scroll-to-top">
    <a href="#header" class="smooth-anchor">
        <i class="icon-arrow-up"></i>
    </a>
</div><?php /**PATH E:\xampp\htdocs\php\angularlaravel\primx\backend\resources\views/layouts/includes/modal_guest.blade.php ENDPATH**/ ?>