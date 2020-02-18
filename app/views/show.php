<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://unpkg.com/picnic" />
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
</head>
<body>

<main class="intro test">


<div class="flex three center demo">
	<article class="half center">
		<h1><?php echo $data['questionnaire']['title']; ?></h1>
		<?php echo $data['questionnaire']['description']; ?>
	</article>
</div>

<div class="flex three center demo">
	<article class="half center">
	<!-- LIST QUESTIONS -->
	<form action="/questions/public/register" method="POST">
	<div>
		<?php
			$total_questions = count($data['questions']);
			
			//Max 12 questions by form:
			switch ($total_questions) 
			{
				case 1:	$div_size = 'one'; break;
				case 2:	$div_size = 'two'; break;
				case 3:	$div_size = 'three'; break;
				case 4: $div_size = 'four'; break;
				case 5: $div_size = 'five'; break;
				case 6: $div_size = 'six'; break;
				case 7: $div_size = 'seven'; break;
				case 8: $div_size = 'eight'; break;
				case 9: $div_size = 'nine'; break;
				case 10: $div_size = 'ten'; break;
				case 11: $div_size = 'eleven'; break;
				case 12: $div_size = 'twelve'; break;
			}

		?>
	    <div class="tabs <?php echo $div_size; ?>">
	    <?php
		for ($i=1; $i <= $total_questions ; $i++) 
		{
		?>
	      <input id='tabQ-<?php echo $i; ?>' type='radio' name='tabgroupD' <?php echo ($i==1)? 'checked' : '';?> />
	      <label class="pseudo button toggle" for="tabQ-<?php echo $i; ?>">•</label>
		<?php
		}
		?>
		<div class="row">
	    	<?php
			$i = 1;
			foreach ($data['questions'] as $question) 
			{
				$next_question = ($i != $total_questions ) ? $i+1 : false;
				$back_question = ($i!=1) ? $i-1 : false;
			?>
		        <div class='tab'>
		          <div class="card" style="margin: 0 20px;">
		            <header>
		            	<?php echo '<h3>' . $i . ' - ' . $question['question'] .'</h3>'; ?>
		            </header>
		            <section>
		            	<?php echo '<label><input type="text" name="answer['.$question['id'].']" maxlength="255" placeholder="Answer" required="required"></label>'; ?>
		            </section>
		            <footer>
		            	<?php

		            	// Buttons Back
		            	if ($back_question) 
		            	{
		            		echo '<label class="button dangerous left" for="tabQ-'.$back_question.'">Back</label>';
		            	}

		            	// Buttons Next/Finish
		            	if ($next_question) 
		            	{
		            		echo '<label class="button" for="tabQ-'.$next_question.'">Next</label>';
		            	}
		            	else
		            	{
		            		echo '<input type="hidden" name="id_questionnaire" value="'.$data['questionnaire']['id'].'" />';
		            		echo '<input class="button" name="register_answers" type="submit" value="Finish">';	
		            	}
		            	?>
		            </footer>
		          </div>
		        </div>
			<?php
				$i++;
			}
			?>
	    </div>
	    </div>

	</div>
	</form>
	</article>
</div>

</main>
</body>
</html>