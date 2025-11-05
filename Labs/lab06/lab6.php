<?php
/*  
Below are my answers to the lab questions. 

1) Explain what each of your classes and methods does, the order in which methods are invoked, and the flow of execution after one of the operation buttons has been clicked.

Classes and flow after clicking a button:
Operation holds the two numbers and says every subclass must have operate() and getEquation()
Subclasses: Addition, Subtraction, Multiplication, Division. Each does its own math in operate() and formats it in getEquation().
Flow: 
1. User types in two numbers and clicks a button.
2. Form sends a POST request to this same page.
3. PHP grabs the numbers from $_POST.
4. Check which button was pressed using our $operations array.
5. Instantiate the right class (Addition, Subtraction, etc.).
6. Call getEquation() → which calls operate() under the hood.
7. Result shows up in <pre> on the page. Any errors (like divide by zero or letters instead of numbers) get printed too.

2) Also explain how the application would differ if you were to use $_GET, and why this may or may not be preferable.

If we used $_GET instead of $_POST, the numbers and button clicked would be sent in the URL, 
like lab6.php?op1=10&op2=5&mult=Multiply. This can be helpful because it’s easy to share or 
bookmark a calculation, and you can see what was sent. But it also shows the values in the URL, 
which isn’t very secure, and people could accidentally change or share the URL with wrong numbers. 
For this lab, $_POST is better because it keeps the numbers hidden and is the usual way to send 
data when a form does something instead of just showing information.


3) Finally, please explain whether or not there might be another (better +/-) way to determine which button has been pressed and take the appropriate action

Right now, we figure out which button was pressed by giving each button its own 
name and checking isset($_POST['add']), isset($_POST['sub']), and so on. A better 
way could be to use a dropdown menu with one submit button, and then check $_POST['operation'] 
to see which operation was chosen. Another option is to give all the buttons the same name but 
different values, and then check $_POST['action']. These approaches make the HTML cleaner and 
make it easier to add more operations in the future.

*/

// Abstract class
abstract class Operation {
    protected $operand_1;
    protected $operand_2;

    public function __construct($o1, $o2) {
        if (!is_numeric($o1) || !is_numeric($o2)) {
            throw new Exception('Non-numeric operand.');
        }
        $this->operand_1 = $o1;
        $this->operand_2 = $o2;
    }

    public abstract function operate();
    public abstract function getEquation();
}

// Addition
class Addition extends Operation {
    public function operate() {
        return $this->operand_1 + $this->operand_2;
    }
    public function getEquation() {
        return "{$this->operand_1} + {$this->operand_2} = " . $this->operate();
    }
}

// Subtraction
class Subtraction extends Operation {
    public function operate() {
        return $this->operand_1 - $this->operand_2;
    }
    public function getEquation() {
        return "{$this->operand_1} - {$this->operand_2} = " . $this->operate();
    }
}

// Multiplication
class Multiplication extends Operation {
    public function operate() {
        return $this->operand_1 * $this->operand_2;
    }
    public function getEquation() {
        return "{$this->operand_1} * {$this->operand_2} = " . $this->operate();
    }
}

// Division
class Division extends Operation {
    public function operate() {
        if ($this->operand_2 == 0) {
            throw new Exception("Division by zero");
        }
        return $this->operand_1 / $this->operand_2;
    }
    public function getEquation() {
        if ($this->operand_2 == 0) {
            return "Cannot divide {$this->operand_1} by zero";
        }
        return "{$this->operand_1} / {$this->operand_2} = " . $this->operate();
    }
}

// Init
$op = null;
$err = array();

// Handle POST form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $o1 = $_POST['op1'] ?? null;
    $o2 = $_POST['op2'] ?? null;

    if ($o1 === null || $o2 === null || $o1 === "" || $o2 === "") {
        $err[] = "Both numbers need to be entered!";
    } else {
        $operations = [
            'add' => 'Addition',
            'sub' => 'Subtraction',
            'mult' => 'Multiplication',
            'div' => 'Division'
        ];

        try {
            foreach ($operations as $key => $class) {
                if (isset($_POST[$key])) {
                    $op = new $class($o1, $o2);
                    break;
                }
            }
        } catch (Exception $e) {
            $err[] = $e->getMessage();
        }
    }
}
?>

<!doctype html>

<html>
<head>
<title>Lab 6 - PHP Calculator</title>
</head>
<body>
<h1>My PHP Calculator</h1>

<pre id="result">
<?php
if (isset($op)) {
    try {
        echo $op->getEquation();
    } catch (Exception $e) {
        $err[] = $e->getMessage();
    }
}

foreach ($err as $error) {
    echo $error . "\n";
}
?>
</pre>

<form method="post" action="">
    <input type="text" name="op1" value="" placeholder="First number" />
    <input type="text" name="op2" value="" placeholder="Second number" />
    <br/><br/>
    <input type="submit" name="add" value="Add" />
    <input type="submit" name="sub" value="Subtract" />
    <input type="submit" name="mult" value="Multiply" />
    <input type="submit" name="div" value="Divide" />
</form>
</body>
</html>
