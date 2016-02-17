# XenForo-FullMessageTextPerm

Adds permissions to include full message text in emails, per usergroup. 
Controls how many characters can be included if the "Full message text notification emails" permission is not set.
Option to always send watched thread notification emails.

Two permissions:
- Full message text notification emails (conversation)
- Full message text notification emails (posts/threads)
- Always email watched thread notifications (posts/threads)

Effects the following
- New thread (watched forum)
- Reply to thread (watched forum, or watch thread)
- New Conversation
- Join conversation
- Reply Conversation

Option to always send emails triggered by warning conversations in full.

To bulk opt-in watch thread notifications:
```
update xf_user_option set fmp_always_email_notify = 1;
```
Ensure the users have the relevent permission.

Thanks to kontrabass of http://www.talkbass.com 