<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class FeaturedController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public $layout = 'main-makeyourown.php';
    public function behaviors()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $data = \app\models\Tables::find()
            ->select(['fk_dimension_time', 'tables_value', 'year', 'fk_dimension_province'])
            ->joinWith('dimensiontimee')
            ->groupBy('year')
            ->where('fk_dimension_province = 17')
            ->asArray()
            ->all();

        $chartData = [];
        foreach ($data as $row) {
            $chartData[] = [(int) $row['year'], (float) $row['tables_value']];
        }
        // Render the index page with chart data
        return $this->render('index', [
            'chartData' => json_encode($chartData), // Pass chart data to the view
        ]);
    }

    public function actionPoverty()
    {
        $data = \app\models\Tables::find()
            ->select(['fk_dimension_time', 'tables_value', 'year', 'fk_dimension_province'])
            ->joinWith('dimensiontimee')
            ->groupBy('year')
            ->where('fk_dimension_province = 17')
            ->asArray()
            ->all();

        $chartData = [];
        foreach ($data as $row) {
            $chartData[] = [(int) $row['year'], (float) $row['tables_value']];
        }
        // Render the index page with chart data
        return $this->render('poverty', [
            'chartData' => json_encode($chartData), // Pass chart data to the view
        ]);
    }

    public function actionInflation()
    {
        $data = \app\models\Tables::find()
            ->select(['fk_dimension_time', 'tables_value', 'year', 'fk_dimension_province'])
            ->joinWith('dimensiontimee')
            ->groupBy('year')
            ->where('fk_dimension_province = 17')
            ->asArray()
            ->all();

        $chartData = [];
        foreach ($data as $row) {
            $chartData[] = [(int) $row['year'], (float) $row['tables_value']];
        }
        // Render the index page with chart data
        return $this->render('inflation', [
            'chartData' => json_encode($chartData), // Pass chart data to the view
        ]);
    }

    public function actionEconomicgrowth()
    {
        $data = \app\models\Tables::find()
            ->select(['fk_dimension_time', 'tables_value', 'year', 'fk_dimension_province'])
            ->joinWith('dimensiontimee')
            ->groupBy('year')
            ->where('fk_dimension_province = 17')
            ->asArray()
            ->all();

        $chartData = [];
        foreach ($data as $row) {
            $chartData[] = [(int) $row['year'], (float) $row['tables_value']];
        }
        // Render the index page with chart data
        return $this->render('economicgrowth', [
            'chartData' => json_encode($chartData), // Pass chart data to the view
        ]);
    }

    public function actionWorkforce()
    {
        $data = \app\models\Tables::find()
            ->select(['fk_dimension_time', 'tables_value', 'year', 'fk_dimension_province'])
            ->joinWith('dimensiontimee')
            ->groupBy('year')
            ->where('fk_dimension_province = 17')
            ->asArray()
            ->all();

        $chartData = [];
        foreach ($data as $row) {
            $chartData[] = [(int) $row['year'], (float) $row['tables_value']];
        }
        // Render the index page with chart data
        return $this->render('workforce', [
            'chartData' => json_encode($chartData), // Pass chart data to the view
        ]);
    }

    public function actionGetdata($variable)
    {
        $data = \app\models\Tables::find()
            ->select([
                'fk_dimension_time',
                'CASE WHEN COUNT(tables_value) > 0 AND SUM(CASE WHEN tables_value IS NOT NULL THEN 1 ELSE 0 END) > 0 THEN ROUND(AVG(tables_value), 2) ELSE NULL END as tables_value', // Round the average value to 2 decimals
                'year',
                'fk_dimension_province',
                'title',
                'fk_dimension_title',
                'unit'
            ])
            ->joinWith(['dimensiontimee', 'dimensiontitlee', 'dimensionunite'])
            ->groupBy(['year'])
            ->where('fk_dimension_title = :variable', [':variable' => $variable])
            ->asArray()
            ->all();

        // Optional: If you want to format the returned data further
        foreach ($data as &$row) {
            if ($row['tables_value'] !== null) {
                $row['tables_value'] = round((float) $row['tables_value'], 2); // Ensure rounding here as well
            }
        }

        return $this->asJson($data);
    }

    public function actionGetdatapie($variable, $year)
    {
        $data = \app\models\Tables::find()
            ->select([
                'fk_dimension_time',
                'CASE WHEN COUNT(tables_value) > 0 AND SUM(CASE WHEN tables_value IS NOT NULL THEN 1 ELSE 0 END) > 0 THEN ROUND(AVG(tables_value), 2) ELSE NULL END as tables_value', // Round the average value to 2 decimals
                'year',
                'fk_dimension_province',
                'title',
                'fk_dimension_title',
                'unit',
                'province_name'
            ])
            ->joinWith(['dimensiontimee', 'dimensiontitlee', 'dimensionunite', 'dimensionprovincee'])
            ->groupBy(['fk_dimension_province'])
            ->where('fk_dimension_title = :variable', [':variable' => $variable])
            ->andWhere(['year' => $year])  // Add filter for year
            ->andWhere(['NOT', ['tables_value' => null]])  // Ensure tables_value is not null
            ->asArray()
            ->all();

        // Optional: If you want to format the returned data further
        foreach ($data as &$row) {
            if ($row['tables_value'] !== null) {
                $row['tables_value'] = round((float) $row['tables_value'], 2); // Ensure rounding here as well
            }
        }

        return $this->asJson($data);
    }

    public function actionGetdatamulti($variable)
    {
        $variableArray = explode(',', $variable);

        // Fetch the data
        $data = \app\models\Tables::find()
            ->select([
                'fk_dimension_time',
                'CASE WHEN COUNT(tables_value) > 0 AND SUM(CASE WHEN tables_value IS NOT NULL THEN 1 ELSE 0 END) > 0 THEN AVG(tables_value) ELSE NULL END as tables_value',
                'year',
                'fk_dimension_province',
                'title',
                'fk_dimension_title',
                'unit'
            ])
            ->joinWith(['dimensiontimee', 'dimensiontitlee', 'dimensionunite'])
            ->where(['fk_dimension_title' => $variableArray])
            ->groupBy(['year', 'fk_dimension_title'])
            ->asArray()
            ->all();

        $formattedData = [];

        // Iterate through the rows from the database query
        foreach ($data as $row) {
            // Get the current year and dimension title
            $year = $row['year'];
            $dimensionTitle = $row['title'];

            // Check if this year is not yet initialized in the formattedData array
            if (!isset($formattedData[$year])) {
                $formattedData[$year] = [];
            }

            // If the value is not NULL, add the entry for that year and title
            if ($row['tables_value'] !== null) {
                $formattedData[$year][$dimensionTitle] = [
                    'value' => round((float) $row['tables_value'], 2),
                    'title' => $row['title'],
                    'unit' => $row['unit']
                ];
            } else {
                // Set the value to null if all rows for that year and title are null
                $formattedData[$year][$dimensionTitle] = [
                    'value' => null, // Explicitly set to null
                    'title' => $row['title'],
                    'unit' => $row['unit']
                ];
            }
        }

        return $this->asJson($formattedData);
    }

    public function actionGetdatamap($variable, $year)
    {
        $data = \app\models\Tables::find()
            ->select([
                'fk_dimension_time',
                'CASE WHEN COUNT(tables_value) > 0 AND SUM(CASE WHEN tables_value IS NOT NULL THEN 1 ELSE 0 END) > 0 THEN AVG(tables_value) ELSE NULL END as tables_value',
                'year',
                'fk_dimension_province',
                'province_highchart_code',
                'title',
                'fk_dimension_title',
                'province_name',
                'unit'
            ])
            ->joinWith(['dimensiontimee', 'dimensiontitlee', 'dimensionunite', 'dimensionprovincee'])
            ->where(['fk_dimension_title' => $variable, 'year' => $year])  // Add filter for year
            ->groupBy(['fk_dimension_province'])
            ->asArray()
            ->all();

        foreach ($data as &$row) {
            if ($row['tables_value'] !== null) {
                $row['tables_value'] = round((float) $row['tables_value'], 2); // Ensure rounding here as well
            }
        }

        return $this->asJson($data);
    }

    public function actionGetdatamapprovince($kdprov, $variable, $year)
    {
        $data = \app\models\Tables::find()
            ->select([
                'fk_dimension_title',
                'fk_dimension_time',
                'tables_value',
                'province_highchart_code',
                'fk_dimension_regency',
                'regency_name',
                'title',
                'unit'
            ])
            ->joinWith(['dimensionprovincee', 'dimensiontitlee', 'dimensionunite', 'dimensionregencye', 'dimensiontimee'])
            ->where(['tables.fk_dimension_province' => $kdprov])
            ->andWhere(['fk_dimension_title' => $variable])
            ->andWhere(['year' => $year])
            ->andWhere(['NOT', ['fk_dimension_regency' => null]])  // Ensure tables_value is not null
            // ->groupBy(['tables.fk_dimension_regency'])
            ->asArray()
            ->all();

        return $this->asJson($data);
    }

    public function actionInsight_openai_old($variable)
    {
        // Fetch your data based on the provided variable
        $data = \app\models\Tables::find()
            ->select([
                'fk_dimension_time',
                'ROUND(AVG(tables_value), 2) as tables_value',
                'year',
                'fk_dimension_province',
                'title',
                'fk_dimension_title',
                'unit'
            ])
            ->joinWith(['dimensiontimee', 'dimensiontitlee', 'dimensionunite'])
            ->groupBy(['year'])
            ->where('fk_dimension_title = :variable', [':variable' => $variable])
            ->asArray()
            ->all();

        // Initialize OpenAiClient and get the generated insight
        $openAiClient = new \app\components\OpenAiClient();
        $insight = $openAiClient->generateInsight($data);

        // Render the insight on a view page
        return $this->render('insight', [
            'data' => $data,
            'insight' => $insight,
        ]);
    }

    public function actionInsight_groq()
    {
        $data = \app\models\Tables::find()
            ->select([
                'fk_dimension_time',
                'CASE WHEN COUNT(tables_value) > 0 AND SUM(CASE WHEN tables_value IS NOT NULL THEN 1 ELSE 0 END) > 0 THEN ROUND(AVG(tables_value), 2) ELSE NULL END as tables_value',
                'year',
                'fk_dimension_province',
                'title',
                'fk_dimension_title',
                'unit'
            ])
            ->joinWith(['dimensiontimee', 'dimensiontitlee', 'dimensionunite'])
            ->groupBy(['year'])
            ->where('fk_dimension_title = :variable', [':variable' => 4])
            ->asArray()
            ->all();

        // Format the data for Groq API
        $query = [
            'data' => $data, // Your data retrieved from the database
            'analysis' => 'Provide insights based on the provided data.'
        ];

        // Initialize the Groq API client and execute the query
        $client = new \app\components\GroqApiClient();
        try {
            $insights = $client->executeQuery($query);
        } catch (\Exception $e) {
            return $this->render('error', ['message' => $e->getMessage()]);
        }

        // Display or process the insights
        return $this->render('insight_groq', ['insights' => $insights]);
    }

    public function actionInsight($variable)
    {
        // Fetch data based on the provided variable
        $data = $this->actionGetdatamulti($variable); // Adjust this to fetch the required data

        // Initialize OpenAiClient and get the generated insight
        $openAiClient = new \app\components\OpenAiClient();
        $insight = $openAiClient->generateInsight($data);

        // Render the insight directly as a string for AJAX response
        return $this->renderPartial('insight', [
            'data' => $data,
            'insight' => $insight,
        ]);
    }

}
