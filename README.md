# mh_directory
The next step to "mh_branchenbuch"; a TYPO3-Extension

[Community-Forum](http://forum.mh-dev.de/threads/13-mh_directory.html) - [ToDo-List](https://github.com/mhdev/mh_directory/wiki/ToDo-List)

## Features

In the beginning the extension will only have some basic features but i promise that it will be at least have ALL features which mh_branchenbuch has and much more!

### LIST-Function

It shows a 3-Way-System for entries. You can categorize the entries in 3 "location"-groups. Federal States, Administrative Districts and Cities. 

#### Step 1 
List of Federal States
![](http://mh-dev.de/mh_directory/list_step_1.png) 
#### Step 2
List of Administrative Districts
![](http://mh-dev.de/mh_directory/list_step_2.png)
#### Step 3
List of Cities
![](http://mh-dev.de/mh_directory/list_step_3.png)
#### Step 4
All entries found in this location
![](http://mh-dev.de/mh_directory/list_step_4.png)
##### Mail-Function
User can send a mail to the company
![](http://mh-dev.de/mh_directory/list_entry_mail.png)

You can define in the TypoScript which field is required
##### Redirecting
If a user clicks the button for website, twitter or facebook, he will be redirectet to this page
![](http://mh-dev.de/mh_directory/list_entry_outgoing.png)
#### TypoScript
* list_show_number_of_entries: Shows the badge behind a headline with the amount of entries inside
* list_hide_empty: Hide empty "categories"
* list_redirecting_time: The time in miliseconds when the user should be redirecting on the "Outgoing"-Page if a user clicks on the button for website, twitter or facebook
* list_mail_required: insert here the required fields for the contact form of a entry (key == name of the input)

All values can be modified in the constant editor!

### Backend-Module

All entries can be modified and added in the default backend of TYPO3. I tried to make the forms as much comfortable as possible and hope you like it. 
![](http://mh-dev.de/mh_directory/backend_form.png)

There is also a backend module available but currently it is empty.

[Community-Forum](http://forum.mh-dev.de/threads/13-mh_directory.html) - [ToDo-List](https://github.com/mhdev/mh_directory/wiki/ToDo-List)


