<?php
include 'config.php';
if(empty($_POST['from'])){
    $_POST['from']="EUR"; // set base currency
}
if(empty($_POST['to'])){
    $_POST['to']="EUR"; // set base currency
}
$req_url = "https://v6.exchangerate-api.com/v6/$api_key/latest/".$_POST["from"]; // API URL
$response_json = file_get_contents($req_url); // import JSON content
$response = json_decode($response_json); // decode JSON content 
if(empty($_POST['somme'])){
    $_POST['somme']=1; // set base amount
}
$base_price = $_POST['somme']; 
$price = round(($base_price * $response->conversion_rates->{$_POST['to']}), 2); // calcul amount in set currency
?>

<style>
<?php include 'css/style.css'; ?>
</style>

<form method="post">
    <h1>Convertisseur</h1>
    <label for="somme">Somme à convertir :</label>
    <input type="number" step="0.01" id="somme" name="somme" required/>
    <br>
    <div class='conversion'>
        <div class="first">
            <label for="from">De :</label>
            <select id="from" name="from">
                <?php foreach($response->conversion_rates as $key => $val) {
                    if ($key) { echo "<option value='$key'".($_POST['from'] == $key ? 'selected="true"':"").">$key</option>"; }; // create select tab for currency
                }?>
            </select>
        </div>
        <div class="second">
            <label for="to">Vers :</label>
            <select id="to" name="to">
                <?php foreach($response->conversion_rates as $key => $val) {
                    if ($key) { echo "<option value='$key'".($_POST['to'] == $key ? 'selected="true"':"").">$key</option>"; }; // create select tab for currency
                }?>
            </select>
        </div>
    </div>
    <br>
    <button type="submit">Convertir</button>
</form>

<p>Résultat de la conversion : </p>
<p><?php echo $_POST['somme']." ".$_POST['from']." = ".$price." ".$_POST['to']; // show the currency exchange?></p> 
