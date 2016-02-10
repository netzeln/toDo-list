<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Task.php";

    session_start();
    if (empty($_SESSION['list_of_tasks'])) {
        $_SESSION['list_of_tasks'] = array();
    }

    $app = new Silex\Application();

    $app->get("/", function(){
        $output = "";

        $all_tasks = Task::getAll();

        if (!empty($all_tasks)){
            $output = $output . "
                <h1>Here's what you need to do</h1>
                ";

            foreach (Task::getAll() as $task){
                $output = $output . "<p>" . $task->getDescription() . "</p>";
            }
        }

        $output = $output . "
            <form action='/tasks' method='post'>
                <label for='description'>Task Description</label>
                <input id='description' name='description' type='text'>

                <button type='submit'>Add Task</button>
            </form>
        ";

        $output .= "
            <form action ='/delete_tasks' method='post'>
                <button type='submit'>DELETE!</button>
            </form>
        ";

      return $output;
    });

    $app->post("/tasks", function(){
        $task = new Task($_POST['description']);
        $task->save();
        return "
            <h1>You made a Task!</h1>
            <p>" . $task->getDescription() . "</p>
            <p><a href='/'> View your list of things to do.</a></p>
        ";
    });

    $app->post("/delete_tasks", function(){
        Task::deleteAll();

        return "
            <h1> ALL DONE!</a1>
            <p><a href='/'>Back to Work!</a></p>
        ";
    });
    return $app;

 ?>
