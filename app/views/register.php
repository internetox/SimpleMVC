<!DOCTYPE html>
<html>
<head>
	<title>Register User</title>
	<link rel="stylesheet" href="https://unpkg.com/picnic" />
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
</head>
<body>

<main class="intro test">
<div class="flex three center demo">
	<article class="half center">
		<h1>Register</h1>
		Please fill the next formulary to register your answers.
	</article>
</div>

<div class="flex three center demo">
	<article class="half center">
	<!-- LIST QUESTIONS -->
	<form action="/questions/public/register/register_user" method="POST">
	<div>
          <div class="card" style="margin: 0 20px;">
            <header>
              <h3>Create account</h3>
            </header>
            <section>
              <input type="text" name="name" placeholder="Name" maxlength="64" required="required">
            </section>
            <section>
              <input type="email" name="email" placeholder="Email" maxlength="255" required="required">
            </section>
            <section>
              <input type="numeric" name="phone" placeholder="Phone" maxlength="32" required="required">
				<input type="hidden" name="id_questionnaire" value="<?php echo $_POST['id_questionnaire']; ?>" />
				<?php
					if (!empty($_POST['answer'])) 
					{
						foreach ($_POST['answer'] as $id => $answer) 
						{
							echo '<input type="hidden" name="answers['.$id.']" value="'.$answer.'" />';
						}
					}
				?>
            </section>
            <footer>
              <button class="success">Finish!</button>
            </footer>
          </div>
	</div>
	</form>
	</article>
</div>

</main>
</body>
</html>