Aliza Syed
Lab 06

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
