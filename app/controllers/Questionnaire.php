<?php


/**
 * Questionnaire
 * Project Name: App
 * @package class
 * @author $Author: David $
 * @version $Revision: 0 $
 *
 */

class Questionnaire extends Controller
{
    function show($id) //Get Questionnaire
    {
    	if (is_numeric($id)) 
    	{
    		$data = $this->model(get_class($this));
            $data->setId($id);
            $data->setFilterAND($id);
            $result_amount = $data->QueryRecordsetCount();

            $data->QueryRecordset($id);
            $data->GetNextRecord();

            $arr = false;
            $arr_result = false;

            if($data !== false && $result_amount > 0)
            {
                $arr['id'] = $data->getId();
                $arr['title'] = $data->getTitle();
                $arr['description'] = $data->getDescription();
                $arr['id_admin'] = $data->getId_admin();
                $arr['datetime'] = $data->getDatetime();

                $questions = $this->questions();

                $questions->setFilterAND('{"Id_questionnaires":'.$arr['id'].'}');
                $cant_records = $questions->QueryRecordsetCount();
                
                $questions->QueryRecordset();
                $arr_questions = false;

                $i=1;
                while($questions->GetNextRecord())
                {
                    $arr_questions[$i]['id'] = $questions->getId();
                    $arr_questions[$i]['question'] = $questions->getQuestion();
                    $arr_questions[$i]['id_admin'] = $questions->getId_admin();
                    $arr_questions[$i]['id_questionnaires'] = $questions->getId_questionnaires();
                    $arr_questions[$i]['datetime'] = $questions->getDatetime();
                    $i++;
                }

                if($arr_questions !== false && $result_amount > 0)
                {
                    $arr_result['questionnaire'] = $arr;
                    $arr_result['questions'] = $arr_questions;
                }
                else
                {
                    $arr_result = false;                  
                }
            }

    		if(is_array($arr_result))
    		{
  		        $this->view('show', $arr_result);
    		}
            else
            {
                require_once(CONTROLLERS . 'Errors.php');
                $error = new Errors();
                $error->error404();
            }

    	}

    }


    public function questions()
    {
        require_once MODELS . ucfirst('questions') . '.php';
        $questions = 'questions'.'Model';
        return new $questions();
    }
}
