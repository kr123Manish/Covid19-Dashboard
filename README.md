## :zap: Project Title*: Covid19 Dashboard <a href='https://finaldev.azurewebsites.net/'>:smiley: click for demo</a>
### Problem Statement/Opportunity*: 
Due to pandemic of covid19 everyone affected and move toward online medical services with lots of queries regarding symptoms, safety, myths, vaccination info and many more. But because of unfriendly interface of online medical service provider most of the people don’t prefer it and go to covid center’s or hospitals directly which increases unnecessary crowd, to solve this issue I build a user-friendly full stack web app with the prospective of both user and admin to raise and solve their quarries online easily.
## Project Description*:
A)	The core idea of the project is to build a full-stack user friendly interface web app with the help of Azure chatbot, SQL database, web app service.
<br></br><img src="https://github.com/Kr321Manish/azure_project/blob/main/ScreenShorts/1.PNG"></img><br></br>
B)	How are we solving:

1)	User Problems Solution: 
1.1)	To solving users queries we build a chatbot using azure QnA Maker, with the reference of Indian govt cowin portal (https://www.cowin.gov.in/).
<br></br><img src="https://github.com/Kr321Manish/azure_project/blob/main/ScreenShorts/2.PNG"></img><br></br>
1.2)	If user still unable to solve their issue they can create their own account and login using mobile number to maintain their privacy, then send message and discuss to team of frontline helper personally who can help them to resolve their issues on discussion board and guide or help according to situation. 
<br></br><img src="https://github.com/Kr321Manish/azure_project/blob/main/ScreenShorts/5.PNG"></img><br></br>
1.3)	To store their all-discussion histories, we use azure SQL server, if questions are common or asked maximum time it will be updated to QnA bot also.
1.4)	We stored user details (mobile no, name, unique id) in SQL server for continue their discussion in future.
- User Discussion Interface.
<br></br><img src="https://github.com/Kr321Manish/azure_project/blob/main/ScreenShorts/4.PNG"></img><br></br>
2)Frontline Helper:

2.1) We assign login credentials through which admin handle queries of people, through friendly web interface which is similar to watts-app on which they can discuss and maintain status of queries (open, closed, solved).
- ## For admin login use email="bob@gmail.com", password="bob1112"
<br></br><img src="https://github.com/Kr321Manish/azure_project/blob/main/ScreenShorts/6.PNG"></img><br></br>
- Admin can reset their password using thier unique service number.
<br></br><img src="https://github.com/Kr321Manish/azure_project/blob/main/ScreenShorts/8.PNG"></img><br></br>
- Reset password link appear only when you enter valid email id.
<br></br><img src="https://github.com/Kr321Manish/azure_project/blob/main/ScreenShorts/7.PNG"></img><br></br>
<br></br><img src="https://github.com/Kr321Manish/azure_project/blob/main/ScreenShorts/9.PNG"></img><br></br>
- These all-discussion histories also store on azure SQL server.
- Admin Discussion Interface.
<br></br><img src="https://github.com/Kr321Manish/azure_project/blob/main/ScreenShorts/10.PNG"></img><br></br>

2.2) In custom way admin can search user through mobile no, which acts as a primary key.
<br></br><img src="https://github.com/Kr321Manish/azure_project/blob/main/ScreenShorts/3.PNG"></img><br></br>

## <a href='https://finaldev.azurewebsites.net/'>:smiley: Project demo link</a>
#### If you liked :smiley: it don't forget to :star: it.

