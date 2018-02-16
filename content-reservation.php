<?php
global $translation;
?>

<style>
.mystep {
    display: none;
}

.mystep.active {
    display: block;
    border: 1px solid green;
}

.myfield {
    display: block;
}
</style>

<div>
    <form class="myform">
        <div class="mystep">
            <div><h2>Primer paso</h2></div>
            <input type="text" name="name" placeholder="name" class="myfield" required>
            <input type="text" name="fullname" placeholder="fullname" class="myfield">
            <input type="number" name="age" placeholder="age" class="myfield" required>
        </div>
        <div class="mystep">
            <div><h2>Segundo paso</h2></div>
            <input type="email" name="email" placeholder="email" class="myfield">
            <input type="text" name="likes" placeholder="likes" class="myfield" required>
            <textarea name="description" placeholder="comment" class="myfield"></textarea>
        </div>

        <div class="controls">
            <button class="next">next</button>
            <button class="prev">prev</button>
        </div>
    </form>
</div>

<div class="row reservation-container">
    <div class="reservation-wrapper w-100">
        <div class="container">
            <div class="reservation-title text-center">
                <h3>Elije tu translado</h3>
            </div>
            <div class="form-container">
                <form class="form">
                    <div class="steps current firstStep">   
                        <div class="step">
                            <div class="row no-gutters align-items-center">
                                <div class="col">
                                    <?php
                                        $placeholder = $translation['TAXI_BOOKING_CHOOSE_CITY'];
                                        $cities = generateSelectByMethod('getCities', "id_province", "name", array('placeholder' => $placeholder, 'data-message' => 'City is missing', 'required' => 'required'));

                                        echo $cities;
                                    ?>
                                </div>
                                <div class="col-auto">
                                    <label class="col-form-label p-2">
                                        <span>
                                            <?php echo $translation['TAXI_BOOKING_TRIP_TWO_WAY']; ?>
                                        </span>
                                        <input type="radio" class="roundtrip" value="1" name="roundtrip" checked required />
                                    </label>

                                    <label class="col-form-label p-2">
                                        <span>
                                            <?php echo $translation['TAXI_BOOKING_TRIP_ONE_WAY']; ?>
                                        </span>
                                        <input type="radio" class="roundtrip" value="0" name="roundtrip" />
                                    </label>
                                </div>
                            </div>

                            <div class="row no-gutters align-items-center">
                                <div class="col">
                                    <label class="col-form-label p-2">
                                        <?php echo $translation['TAXI_BOOKING_START_FROM']; ?>
                                    </label>
                                </div>

                                <div class="col-auto">
                                    <label class="col-form-label p-2">
                                        <span>
                                            <?php echo $translation['TAXI_BOOKING_AIRPORT']; ?>
                                        </span>
                                        <input type="radio" class="startfrom" value="0" name="startFrom" required />
                                    </label>

                                    <label class="col-form-label p-2">
                                        <span>
                                            <?php echo $translation['TAXI_BOOKING_HOME']; ?>
                                        </span>
                                        <input type="radio" class="startfrom" value="1" name="startFrom" />
                                    </label>
                                </div>
                            </div>

                            <div class="row no-gutters align-items-center">
                                <div class="col">
                                    <select id="passengers" required class="form-control form-control-sm form-control-border t-input-control">
                                        <option value="1" selected>1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    <select>
                                </div>

                                <div class="col-auto">
                                    <label class="col-form-label p-2">
                                        <span>
                                            <?php echo $translation['TAXI_BOOKING_PASSENGERS']; ?>
                                        </span>
                                    </label>
                                </div>
                            </div>

                            <div class="row no-gutters align-items-center vertical-separator">
                                <div class="col">
                                    <i class="fa fa-spinner fa-spin d-none spinner-commune"></i>
                                    <?php
                                        $placeholder = $translation['TAXI_BOOKING_CHOOSE_COMMUNE'];
                                        $communes = generateSelectByMethod('getCommuneByCityId', "id_commune", "name", array('placeholder' => $placeholder, 'data-message' => 'Commune is missing', 'required' => 'required'), 0);

                                        echo $communes;
                                    ?>
                                </div>

                                <div class="w-100">
                                </div>

                                <div class="col vertical-separator">
                                    <div class="form-row">
                                        <div class="col-7">
                                            <input type="text" required id="street" data-id="street" placeholder="<?php echo $translation['TAXI_BOOKING_STREET']; ?>" class="t-input-control form-control form-control-sm form-control-border" />
                                        </div>

                                        <div class="col">
                                            <input type="text" required id="build_nro" data-id="build_nro" placeholder="<?php echo $translation['TAXI_BOOKING_BUILDING']; ?>" class="t-input-control form-control form-control-sm form-control-border" />
                                        </div>

                                        <div class="col">
                                            <input type="text" required id="dpto" data-id="dpto" placeholder="<?php echo $translation['TAXI_BOOKING_DEPTO']; ?>" class="t-input-control form-control form-control-sm form-control-border" />
                                        </div>
                                    </div>
                                </div>

                                <div class="w-100">
                                </div>

                                <div class="col vertical-separator">
                                    <input type="text" id="reference_point" name="reference_point" data-id="reference_point" placeholder="<?php echo $translation['TAXI_BOOKING_REFERENCE']; ?>" class="t-input-control form-control form-control-sm form-control-border" />
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary btn-block next-step"><?php echo $translation['TAXI_BOOKING_NEXT_BUTTON']; ?></button>
                    </div>

                    <div class="steps secondStep">
                        <div class="step">
                            <div class="row no-gutters align-items-center">
                                <div class="col-label">
                                    <?php echo $translation['TAXI_BOOKING_GO'] ?>
                                </div>

                                <div class="w-100 d-sm-none d-md-none d-lg-none d-xl-none"></div>

                                <div class="col">
                                    <div class="d-flex align-items-center container-field">
                                        <input type="text" name="date_start" id="date_start" class="form-control reservation-field date-input" />
                                        <i class="fa fa-calendar field-icon" aria-hidden="true"></i>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="d-flex align-items-center container-field">
                                        <input type="text" name="time_start" id="time_start" class="form-control reservation-field date-input" />
                                        <i class="fa fa-clock-o field-icon" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="row no-gutters align-items-center container-return-date">
                                <div class="col-label col-xs-12">
                                    <?php echo $translation['TAXI_BOOKING_RETURN'] ?>
                                </div>

                                <div class="w-100 d-sm-none d-md-none d-lg-none d-xl-none"></div>

                                <div class="col">
                                    <div class="d-flex align-items-center container-field">
                                        <input type="text" name="date_end" id="date_end" class="form-control reservation-field date-input" />
                                        <i class="fa fa-calendar field-icon" aria-hidden="true"></i>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="d-flex align-items-center container-field">
                                        <input type="text" name="time_end" id="time_end" class="form-control reservation-field date-input" />
                                        <i class="fa fa-clock-o field-icon" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col btn-group">
                                <button class="btn btn-primary form-control prev-step"><?php echo $translation['TAXI_BOOKING_PREV_BUTTON']; ?></button>
                                <button class="btn btn-primary form-control next-step"><?php echo $translation['TAXI_BOOKING_NEXT_BUTTON']; ?></button>
                            </div>
                        </div>
                    </div>

                    <div class="steps thirdStep">
                        <div class="step services_container">
                        </div>

                        <div class="row">
                            <div class="col btn-group">
                                <button class="btn btn-primary prev-step form-control"><?php echo $translation['TAXI_BOOKING_PREV_BUTTON']; ?></button>
                                <button class="btn btn-primary next-step form-control"><?php echo $translation['TAXI_BOOKING_NEXT_BUTTON']; ?></button>
                            </div>
                        </div>
                    </div>

                    <div class="steps fourthStep">
                        <div class="step">
                            <div class="row no-gutters align-items-center">
                                <div class="col">
                                    <input type="text" data-id="passenger_fullname" placeholder="<?php echo $translation['TAXI_BOOKING_PASSENGER_FULLNAME'] ?>" class="t-input-control form-control form-control-sm form-control-border" />
                                </div>
                            </div>
                            
                            <div class="row no-gutters align-items-center vertical-separator">
                                <div class="col">
                                    <input type="text" data-id="passenger_id" class="t-input-control form-control form-control-sm form-control-border" />
                                </div>

                                <div class="col-auto">
                                    <label class="col-form-label p-2">
                                        <span>
                                            <?php echo $translation['TAXI_BOOKING_PASSENGER_RUT']; ?>
                                        </span>
                                        <input type="radio" class="passengerId" value="rut" name="passenderid" checked />
                                    </label>

                                    <label class="col-form-label p-2">
                                        <span>
                                            <?php echo $translation['TAXI_BOOKING_PASSENGER_PASSPORT']; ?>
                                        </span>
                                        <input type="radio" class="passengerId" value="passport" name="passenderid" />
                                    </label>
                                </div>
                            </div>

                            <div class="row align-items-center vertical-separator">
                                <div class="col">
                                    <input type="text" data-id="passenger_email" placeholder="<?php echo $translation['TAXI_BOOKING_PASSENGER_EMAIL'] ?>" class="t-input-control form-control form-control-sm form-control-border" />
                                </div>

                                <div class="col">
                                    <input type="text" data-id="passenger_phone" placeholder="<?php echo $translation['TAXI_BOOKING_PASSENGER_PHONE'] ?>" class="t-input-control form-control form-control-sm form-control-border" />
                                </div>
                            </div>

                            <div class="container-resume vertical-separator">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col btn-group">
                                <button class="btn btn-primary prev-step form-control"><?php echo $translation['TAXI_BOOKING_PREV_BUTTON']; ?></button>
                                <button class="btn btn-primary btn-submit form-control"><?php echo $translation['TAXI_BOOKING_SUBMIT_BUTTON']; ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>