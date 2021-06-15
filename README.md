# CodeIgniter 4 Blog

this branch has the authentification feature, a user need to be connected to perform some actions like like, dislike, post comment

## The home page

- The home page display all posts with their realted tags
- you can click the title or description of the post, to view it
- at the bottom there is a simple navigation for next posts

## The post view page
- the view page display the title of the post and it's full body
- on the right sidebar, you can find:
1. posted date of the post
2. number of comments
3. tags
4. reactions(like and dislike)
5. comments

## Reactions (like and dislike)
Reactions are like and dislike and are based on the ip address of the user, no account is needed; it mean that when the user change it's ip address, the related data is losted

## Comments
- each post can have at most 3 comments <br>
- you need to enter your full name in order to post a comment
- at the bottom, you can find list of all comments

## Tags
- each post can have at least 3 tags

## Admin

in order to manage posts and tags(create, edit, delete), you need to be connected as admin. to do so, you need to login with username: `admin` and password: `admin`<br><br>
after you are connected, each post and tag will be displayed with the `delete` and `edit` button link