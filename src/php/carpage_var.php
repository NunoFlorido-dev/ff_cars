<?php
include("php/connection.php");
include("php/definemode.php");

function changeLeftPart($alternateMode){
    if(!$alternateMode){
        echo '<form method="post" action="php/bookcar.php">
        <input type="hidden" name="license_plate" value="<?php echo htmlspecialchars($car["license_plate"]); ?>

<div class="dates">
    <label for="begin-time">Begin Time</label>
    <input type="date" id="begin-time" name="begin-time">

    <label for="end-time">End Time</label>
    <input type="date" id="end-time" name="end-time"
</div>

<br>
<button type="submit" id="add-pay" formaction="cart.php">Add to Cart & Pay</button>
<br>
<button type="submit" id="add-continue">Add to Cart & Continue Search</button>

</form>';
    }
}