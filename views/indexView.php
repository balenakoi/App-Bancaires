<?php

include('includes/header.php');

?>

<div class="container">

	<header class="flex">
		<p class="margin-right">Bienvenue sur l'application Comptes Bancaires</p>
	</header>

	<h1>Mon application bancaire</h1>

	<form class="newAccount" action="index.php" method="post">
		<label>Sélectionner un type de compte</label>
		<select class="" name="name" required>
			<option value="" disabled>Choisissez le type de compte à ouvrir</option>
			<?php  ?>
		</select>
		<input type="submit" name="new" value="Ouvrir un nouveau compte">
	</form>

	<hr>

	<div class="main-content flex">

	<?php foreach ($takeAccounts as $account) { ?>
		<div class="card-container">

			<div class="card">
				<h3><strong><?php  ?></strong></h3>
				<div class="card-content">


					<p>Somme disponible : <?php  ?> €</p>

					<!-- Form for deposit / withdrawal -->
					<h4>Dépot / Retrait</h4>
					<form action="index.php" method="post">
						<input type="hidden" name="id" value=" <?php  ?>"  required>
						<label>Entrer une somme à débiter/créditer</label>
						<input type="" name="balance" placeholder="Ex: 250" >
						<input type="submit" name="payment" value="Créditer">
						<input type="submit" name="debit" value="Débiter">
					</form>


					<!-- Form for transfer -->
			 		<form action="index.php" method="post">

						<h4>Transfert</h4>
						<label>Entrer une somme à transférer</label>
						<input type="number" name="balance" placeholder="Ex: 300"  required>
						<input type="hidden" name="idDebit" value="<?php  ?>" required>
						<label for="">Sélectionner un compte pour le virement</label>
						<select name="idPayment" required>
							<option value="" disabled>Choisir un compte</option>
							<?php  ?>
						</select>
						<input type="submit" name="transfer" value="Transférer l'argent">
					</form>

					<!-- Form for deletion -->
			 		<form class="delete" action="index.php" method="post">
				 		<input type="hidden" name="id" value="<?php  ?>"  required>
				 		<input type="submit" name="delete" value="Supprimer le compte">
			 		</form>

				</div>
			</div>
		</div>

	<?php 
}
// ######### FIN DU CODE A GENERER A CHAQUE TOUR DE BOUCLE ######### ?>

	</div>

</div>

<?php

include('includes/footer.php');

?>
