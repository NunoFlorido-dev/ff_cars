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
        echo '<form method="post" action="../pages/car_form.php">
         <input type="hidden" name="license_plate" value="' . htmlspecialchars($car['license_plate']) . '">
        
         <button type="submit" id="edit">Edit</button>
        </form>';

    }
}
