<p>Copier / Coller le contenu du champ ci-dessous :</p>
<input type="text" value="data:image/png;base64,<?= base64_encode(file_get_contents('./emptysignature.png')) ?>" style="width: 50%" />
<p>Ensuite, intégrer le contenu dans la variable d'environnement APP_NO_IMAGE_DATA (dans le virtualhost pour apache par exemple)</p>
<p>Cette chaine sert pour la validation des réservations non signées.<br />Si elle n'est pas présente ou erronée, les réservations pourront être validées sans signature.</p>