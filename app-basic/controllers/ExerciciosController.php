<?php

namespace app\controllers;

use app\models\CadastroModel;
use app\models\Pessoas;
use Yii;
use yii\base\Controller;
use yii\data\Pagination;

class ExerciciosController extends Controller
{
    public function actionFormulario()
    {
        $cadastroModel = new CadastroModel();
        $post = Yii::$app->request->post();

        if ($cadastroModel->load($post) && $cadastroModel->validate()) {
            // Salvar os dados no banco de dados
            $cadastroModel->save();

            return $this->render('formulario-confirmacao', [
                'model' => $cadastroModel
            ]);
        } else {
            return $this->render('formulario', [
                'model' => $cadastroModel
            ]);
        }
    }

    public function actionPessoas()
    {
      
      $query = Pessoas::find();

      $pagination = new Pagination([
         'defaultPageSize' => 3,
         'totalCount' => $query->count()
      ]);

      $pessoas = $query->orderBy('nome')
                       ->offset($pagination->offset)
                       ->limit($pagination->limit)
                       ->all();

      return $this->render('pessoas', [
        'pessoas' => $pessoas,
        'pagination' => $pagination,
      ]);                 
     // buscar por registros   
     /* $pessoas = Pessoas::find()->orderBy('nome')->all();
      echo '<pre>'; print_r($pessoas);*/
     
      // buscar algum registro especifico
      //$pessoa = Pessoas::findOne(2);
      //echo $pessoa->nome . ' - ' . $pessoa->email;
      // $pessoa->nome = 'Gustavo Viana';
      // $pessoa->save();

   
    }
}

