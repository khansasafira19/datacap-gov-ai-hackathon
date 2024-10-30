<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Tables;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
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

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $this->layout = 'main-login';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionGetdataindex($variable)
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

    public function actionGetdata()
    {
        // Retrieve the 'variables' and 'years' from GET parameters as comma-separated strings
        $variables = Yii::$app->request->get('variables');
        $years = Yii::$app->request->get('years');
        $semesters = Yii::$app->request->get('semesters');
        $months = Yii::$app->request->get('months');

        // Convert comma-separated strings to arrays if necessary
        $variables = is_string($variables) ? explode(',', $variables) : (array) $variables;
        $years = is_string($years) ? explode(',', $years) : (array) $years;

        // Start building the query
        $query = \app\models\Tables::find()
            ->select([
                'fk_dimension_time',
                'CASE WHEN COUNT(tables_value) > 0 AND SUM(CASE WHEN tables_value IS NOT NULL THEN 1 ELSE 0 END) > 0 THEN ROUND(AVG(tables_value), 2) ELSE NULL END as tables_value', // Round the average value to 2 decimals
                'year',
                'semester',
                'month',
                'fk_dimension_province',
                'title',
                'fk_dimension_title',
                'unit'
            ])
            ->joinWith(['dimensiontimee', 'dimensiontitlee', 'dimensionunite'])  // Ensure these relations exist
            ->groupBy(['year', 'semester', 'month'])
            ->where(['fk_dimension_title' => $variables])
            ->andWhere(['year' => $years]);  // Filter by years

        // Apply semester filter if provided
        if (!empty($semesters)) {
            $semesters = is_string($semesters) ? explode(',', $semesters) : (array) $semesters;
            $query->andWhere(['semester' => $semesters]);
        }

        // Apply month filter if provided
        if (!empty($months)) {
            $months = is_string($months) ? explode(',', $months) : (array) $months;
            $query->andWhere(['month' => $months]);
        }

        // Execute the query and get the data
        $data = $query->asArray()->all();

        // Optional: Further format or process the data
        foreach ($data as &$row) {
            if ($row['tables_value'] !== null) {
                $row['tables_value'] = round((float) $row['tables_value'], 2);
            }
        }

        // Log the final result for debugging
        Yii::info($data, 'chart-data-response');

        return $this->asJson($data);  // Return the data as JSON
    }

    public function actionGetdatamultiindex($variable)
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

    public function actionGetdatamulti($variable, $year)
    {
        $variableArray = explode(',', $variable);
        $yearArray = explode(',', $year);

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
            ->andWhere(['year' => $yearArray])
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
                'CASE WHEN COUNT(tables_value) > 0 AND SUM(CASE WHEN tables_value IS NOT NULL THEN 1 ELSE 0 END) > 0 THEN ROUND(AVG(tables_value), 2) ELSE NULL END as tables_value',
                'year',
                'fk_dimension_province',
                'province_highchart_code',
                'title',
                'fk_dimension_title',
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

    public function actionMakeyourown()
    {
        $this->layout = 'main-makeyourown';
        // Find only dimension titles that have corresponding values in the tables
        $variables = \app\models\DimensionTitle::find()
            ->innerJoin('tables', 'tables.fk_dimension_title = dimension_title.id_dimension_title')
            ->where(['not', ['tables_value' => null]]) // Filter where tables_value is not null
            ->groupBy('dimension_title.id_dimension_title') // Ensure each title is only selected once
            ->all();

        // Find only years that have corresponding values in the tables
        $years = \app\models\DimensionTime::find()
            ->innerJoin('tables', 'tables.fk_dimension_time = dimension_time.id_dimension_time')
            ->where(['not', ['tables_value' => null]]) // Filter where tables_value is not null
            ->groupBy('dimension_time.year') // Ensure each title is only selected once
            ->all();

        // Find only years that have corresponding values in the tables
        $semesters = \app\models\DimensionTime::find()
            ->innerJoin('tables', 'tables.fk_dimension_time = dimension_time.id_dimension_time')
            ->where(['not', ['tables_value' => null]]) // Filter where tables_value is not null
            ->groupBy('dimension_time.semester') // Ensure each title is only selected once
            ->all();

        // Find only years that have corresponding values in the tables
        $quarters = \app\models\DimensionTime::find()
            ->innerJoin('tables', 'tables.fk_dimension_time = dimension_time.id_dimension_time')
            ->where(['not', ['tables_value' => null]]) // Filter where tables_value is not null
            ->groupBy('dimension_time.quarter') // Ensure each title is only selected once
            ->all();

        // Find only years that have corresponding values in the tables
        $months = \app\models\DimensionTime::find()
            ->innerJoin('tables', 'tables.fk_dimension_time = dimension_time.id_dimension_time')
            ->where(['not', ['tables_value' => null]]) // Filter where tables_value is not null
            ->groupBy('dimension_time.month') // Ensure each title is only selected once
            ->orderBy('dimension_time.month')
            ->all();

        return $this->render(
            'makeyourown',
            [
                'variables' => $variables,
                'years' => $years,
                'semesters' => $semesters,
                'quarters' => $quarters,
                'months' => $months
            ]
        );
    }

    public function actionLoadyears($fk_dimension_title)
    {
        // Ensure $fk_dimension_title is an array
        if (!is_array($fk_dimension_title)) {
            $fk_dimension_title = [$fk_dimension_title];
        }

        // Fetch years, semesters, and months that have data for any of the selected fk_dimension_title(s)
        $years = \app\models\DimensionTime::find()
            ->innerJoin('tables', 'tables.fk_dimension_time = dimension_time.id_dimension_time')
            ->where(['in', 'tables.fk_dimension_title', $fk_dimension_title]) // Handle multiple titles
            ->groupBy(['dimension_time.year']) // Group by year, semester, and month
            ->all();

        $semesters = \app\models\DimensionTime::find()
            ->innerJoin('tables', 'tables.fk_dimension_time = dimension_time.id_dimension_time')
            ->where(['in', 'tables.fk_dimension_title', $fk_dimension_title]) // Handle multiple titles
            ->groupBy(['dimension_time.semester']) // Group by year, semester, and month
            ->all();

        $months = \app\models\DimensionTime::find()
            ->innerJoin('tables', 'tables.fk_dimension_time = dimension_time.id_dimension_time')
            ->where(['in', 'tables.fk_dimension_title', $fk_dimension_title]) // Handle multiple titles
            ->groupBy(['dimension_time.month']) // Group by year, semester, and month
            ->all();
        // Prepare the response data
        $result = [];
        foreach ($years as $year) {
            $result[] = [
                'year' => $year->year,
            ];
        }
        foreach ($semesters as $semester) {
            $result[] = [
                'semester' => $semester->semester,
            ];
        }
        foreach ($months as $month) {
            $result[] = [
                'month' => $month->month,
            ];
        }

        return $this->asJson($result); // Return the data as JSON
    }

    public function actionLoadvariables($fk_dimension_time)
    {
        // Ensure $fk_dimension_title is an array
        if (!is_array($fk_dimension_time)) {
            $fk_dimension_time = [$fk_dimension_time];
        }
        $variables = \app\models\DimensionTitle::find()
            ->innerJoin('tables', 'tables.fk_dimension_title = dimension_title.id_dimension_title')
            ->innerJoin('dimension_time', 'tables.fk_dimension_time = dimension_time.id_dimension_time')
            ->where(['in', 'dimension_time.year', $fk_dimension_time]) // Handle multiple years
            ->groupBy('dimension_title.id_dimension_title')
            ->all();

        return $this->asJson($variables); // Send the data as a JSON response
    }

    public function actionLoadTimeDetails($year)
    {
        if (!is_array($year)) {
            $year = [$year];
        }
        // Fetch semester, quarter, and month based on the selected year
        $timeData = \app\models\DimensionTime::find()
            ->select(['semester', 'quarter', 'month'])
            ->where(['year' => $year])
            ->asArray()
            ->all();

        // Extract available semesters, quarters, and months
        $semesters = array_unique(array_column($timeData, 'semester'));
        $quarters = array_unique(array_column($timeData, 'quarter'));
        $months = array_unique(array_column($timeData, 'month'));

        // Return data as JSON
        return $this->asJson([
            'semester' => array_filter($semesters),  // Only include non-null values
            'quarter' => array_filter($quarters),
            'month' => array_filter($months)
        ]);
    }

    public function actionCoba()
    {
        $this->layout = 'main-makeyourown';
        return $this->render('coba');
    }
}
