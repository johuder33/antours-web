<?php
    global $postId;
    $fullnameMessage = "Nombre y Apellido es requerido";
    $rutMessage = "Identificacion es requerido";
    $passportMessage = "Pasaporte es requerido";
    $telephoneMessage = "Teléfono es requerido";
    $emailMessage = "Email es requerido";
    $passangerMessage = "Debe escoger al menos un pasajero";
    $hotelMessage = "Debe ingresar una dirección válida";
?>

<form id="form-<?php echo $postId; ?>" data-form-id="<?php echo $postId; ?>" class="single-product-form">
    <div class="single-field-container" id="fullname-<?php echo $postId; ?>">
        <input data-form-id="<?php echo $postId; ?>" data-error-message="<?php echo $fullnameMessage; ?>" maxlength="100" class="simple-form-field" name="fullname" placeholder="Nombre y apellido" type="text" min="8"/>
        <div>
        </div>
    </div>

    <div class="single-field-container" id="id-type-<?php echo $postId; ?>">
        <div class="form-row justify-content-between simple-package-field">
            <div class="col">
                <label>
                    RUT
                    <input data-form-id="<?php echo $postId; ?>" class="id_type" name="simple-form-field id_type" value='rut' type="radio" checked />
                </label>
            </div>

            <div class="col text-right">
                <label>
                    Pasaporte
                    <input data-form-id="<?php echo $postId; ?>" class="id_type" name="simple-form-field id_type" value='passport' type="radio" />
                </label>
            </div>
        </div>
        <div>
        </div>
    </div>

    <div class="single-field-container" id="rut-<?php echo $postId; ?>">
        <input data-form-id="<?php echo $postId; ?>" data-error-message="<?php echo $rutMessage; ?>" maxlength="20" class="simple-form-field" name="id_number" placeholder="Nro. de Identificación" type="text" />
        <div>
        </div>
    </div>

    <div class="single-field-container" id="telephone-<?php echo $postId; ?>">
        <input data-form-id="<?php echo $postId; ?>" data-error-message="<?php echo $telephoneMessage; ?>" maxlength="20" class="simple-form-field" name="telephone" placeholder="Teléfono" type="text" />
        <div>
        </div>
    </div>

    <div class="single-field-container" id="email-<?php echo $postId; ?>">
        <input data-form-id="<?php echo $postId; ?>" data-error-message="<?php echo $emailMessage; ?>" maxlength="255" class="simple-form-field" name="email" placeholder="Email" type="text" />
        <div>
        </div>
    </div>

    <div class="single-field-container" id="passengers-<?php echo $postId; ?>">
        <input data-form-id="<?php echo $postId; ?>" data-error-message="<?php echo $passangerMessage; ?>" maxlength="2" class="simple-form-field" name="passengers" placeholder="Cantidad de pasajeros" type="number" min="0" max="10" />
        <div>
        </div>
    </div>

    <div class="single-field-container" id="hotel_address-<?php echo $postId; ?>">
        <textarea data-form-id="<?php echo $postId; ?>" data-error-message="<?php echo $hotelMessage; ?>" maxlength="255" class="simple-form-field" name="hotel_address" placeholder="Direccion de hotel" type="text" /></textarea>
        <div>
        </div>
    </div>

    <!-- LAYOUT PROGRESS FOR PENDING REQUEST -->
    <div class="form-progress-layout">
        <div class="progress-container">
            <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
            <div class="progress-message" id="progress-message-<?php echo $postId; ?>">
            </div>
        </div>
    </div>
    <!-- LAYOUT PROGRESS FOR PENDING REQUEST -->
</form>