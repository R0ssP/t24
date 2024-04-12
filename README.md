# CS312-Group-Project
In this assignment, you will begin to create a website to generate an activity called a "color coordinate" sheet.  For this first milestone, you will set up the web infrastructure to get started on the project.

Getting Started
You'll notice there are requirements in this assignment that are topics of weeks while the assignment is open.  The expectation is that you work on the assignment as you learn those topics and do a little bit of work each week.

General Requirements
You will create a web page for a fictitious company, including a name and logo.  You must have a homepage with a modern design that includes basic welcome information and contains useful links to get to the other pages on the site.  You must also have an "about" page where you list the names and a brief biography of each group member.  A picture or graphic avatar is required for each member of your team

On the third page, you will have the color coordinate generation.  More details on this, below in the "Color Coordinate Generation" section

Your web page must also be styled, You will need to have at least 3 unique colors displayed on your website, NOT including pure black or white. Additionally any colors used to display text over one color or another must meet the WebAIM accessibility test, your colors chosen for displaying text or acting as a separator between two elements have a contrast value of AT LEAST 7. You can use a comment in your style sheet to include this data and can use this link to check your contrast values (https://webaim.org/resources/contrastchecker/)Links to an external site.

In General, most color palettes usually have 5-7 colors beyond pure black and white so you should try and strive for that as your target for design.

Color Coordinate Generation
This page is a page where it behaves differently if it receives URL parameters. 

In some way your code must take 2 inputs. One for number of Rows & Columns, 1 number, and a second input for number of colors. Rows & Columns must be between 1 and 26, color should be between 1 and 10. Your code must validate these values in some way, meaning that it displays a Meaningful error message if the inputs are invalid. Each set of data should be validated separately and you could have up to 2 different error messages displayed if both values are in error.

If the values pass validation, the color coordinate generation page renders a page with two tables. Note you can do this in multiple ways and even using separate tools such as Javascript, JQuery, Ajax, PHP, whichever works best for your team!

The first (upper) table is a 2 column by x row table, where x is the number of colors indicated by the parameter "colors". The left column is 20% of the table width and the right column is 80%.  The table spans most of the width of the page.  There is no header row on this table.

Below that table is a table that is n+1 x n+1 where n is the indicated row/column size.  This table is always square. All cells should have an equal height and width.

The upper-leftmost cell is empty.  The remaining cells across the top are lettered with capital letters in alphabetical order starting with "A" and going to "Z" (using "Z" for the max size of 26).  The cells in the leftmost column are numbered starting in the second row with "1" and numbering each row consecutively.

Now, in the top table, each of the left column cells has a drop-down with 10 color names (red, orange, yellow, green, blue, purple, grey, brown, black, teal).  Order these in an intuitive way for the user.  Initially, a different color is selected in each drop down.  No two drop downs can select the same color at the same time (if this happens, revert the most recently changed drop down to the previous value that was selected.  Inform the user of this in a non-intrusive way (i.e. not an alert() ).

At the bottom of the page, there is a button.  Pressing this button will take the user to a "printable view" of the resulting tables.  This should have all of the same dimensions as selected and should easily print on one page of 8.5" x 11" paper in portrait mode.  It should render in greyscale and include a greyscale logo and company name as a header.  The selected color names will appear in the cells where the drop downs were, but as plain text.  Note that this is a separate page NOT the print menu, you will only receive half points if this opens the print menu instead of rendering a new page.

Submission
For this assignment you will be simply submitting the URL to your team's page. Each member of the team must have a hosted version of the project.

A suggested path and url for your assignment should look like so

https://cs.colostate.edu:4444/~eid/GroupName/index.phpLinks to an external site.

You should then have a file path from local as:

/local_html/

GroupName/

index.php

Any_other_Files_as_needed

Grading Notes/Group Dynamics
Each member of the group is individually responsible for having a working application.  Group members are expected to work together towards this common goal.  If a group is having a problem with a member, the instructor must be notified right away.  Start this early, as soon as the first week, if a member is not cooperating or is out of contact.  Scores are assigned individually and the instructor will assign differentiated scores based on feedback from members.  Note: It is in your best interest to work together and log all attempts you make to contact members who are not helping.

Grading Breakdown
10 points just for turning in the assignment.
Website has a color scheme of at least 3 unique colors not including Black and White. (10 points)
Colors Displayed over each other as text or to create separation have a WebAIM contrast level of 7 or higher (10 Points)
Member Biographies (10 points)
Color Coordination page has input form (10 points)
Parameter Validation (10 points)
Tables generated as specified (10 points)
Color selector obeys selection restrictions (no duplicate colors and rollback to original choice) (10 points)
Print View (10 points)
Site available on team member's local_html at the specified URL (10 points)***
Submission of team post-survey (10 BONUS points)***  (Survey will be available for a few days starting at the due date of this assignment)
*** Items marked with triple stars (***) are individually graded by student.  Otherwise, the first 8 items will be awarded points to all team members the same.  The notable exception is that team members who did nothing or significantly less work will be penalized, potentially losing all of these points in extreme cases.