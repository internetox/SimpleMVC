<?php


/**
 * Register
 * Project Name: App
 * @package class
 * @author $Author: David $
 * @version $Revision: 0 $
 *
 */

class Register extends Controller
{
    function __construct()
    {
        $request = (!empty($_POST['register_answers'])) ? $_POST['register_answers'] : false;
		if($request)
		{
            $this->view('register',$request);
		}
    }

    function register_user()
    {
        $request = (!empty($_POST['answers'])) ? $_POST: false;
        if($request)
        {
            $users = $this->model('users');

            $users->setEmail($request['email']);
            $users->setName($request['name']);
            $users->setPhone($request['phone']);
            $users->setIp($_SERVER['REMOTE_ADDR']);

            $create_user = $users->Insert();
            if ($create_user) 
            {
                $answers = $this->model('answers');

                foreach ($request['answers'] as $id_answer => $answer_text) 
                {
                    $answers->resetData();
                    $answers->setId_user($users->getId());
                    $answers->setId_questionnaire($request['id_questionnaire']);
                    $answers->setId_question($id_answer);
                    $answers->setAnswer($answer_text);


                    $create_answer = $answers->Insert();
                }

                $this->view('thanks');

            }
            else
            {
                require_once(CONTROLLERS . 'Errors.php');
                $error = new Errors();
                $error->error404($create_user);
            }
        }
        else
        {
            require_once(CONTROLLERS . 'Errors.php');
            $error = new Errors();
            $error->error404();
        }
    }

}