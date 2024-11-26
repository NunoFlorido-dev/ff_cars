<?php
include("../auth/connection.php");

function changeLeftPart($alternateMode){
global $car;

    if(!$alternateMode){
        global $car; // Ensure $car is accessible in this scope
        echo '<form method="post" action="php/bookcar.php">
        <input type="hidden" name="license_plate" value="' . htmlspecialchars($car['license_plate']) . '">

        <div class="dates">
            <label for="begin-time">Begin Time</label>
            <input type="date" id="begin-time" name="begin-time">

            <label for="end-time">End Time</label>
            <input type="date" id="end-time" name="end-time">
        </div>

        <br>
        <button type="submit" id="add-pay" formaction="cart.php">Add to Cart & Pay</button>
        <br>
        <button type="submit" id="add-continue">Add to Cart & Continue Search</button>
    </form>';
    }else{
        echo '<div class="form-link">
    <a href="../pages/car_form.php?license_plate=' . htmlspecialchars($car['license_plate']) . '">Edit</a>
    </div>';

    }
}
