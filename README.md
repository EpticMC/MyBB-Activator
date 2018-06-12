# User-Activator-Backbone

The backbone of the EpticMC user activator for MyBB 

This runs as MyBB Plugin worker and provides an internal RESTful POST API for [api.epticmc.com](https://api.epticmc.com)

Basically, this plugin listens on 

`/misc.php?action=activateuser&acode=ACTIVATION-CODE-HERE` 

and activates users according to the provided activation code.

This is used for the In-Game confirmation of forum accounts. 

If a user registers on the forum, an email with the activation code is sent. 

This code needs to be used In-Game on the server like this:

`/activate ACTIVATION-CODE-HERE`

the plugin then sends a request to 

[https://api.epticmc.com/activate](https://api.epticmc.com/activate)

with the activation code and the UUID of the player. The rest is handled internal by the API. 

Once the validation is done, the API sends a request to misc.php with the activation code parameter.

**Note:** The plugin either returns "ok" or "No user selcted"

## Endpoints and example queries:

[https://api.epticmc.com/activate?usercode=abc&uuid=22891b6c11954740b240247315f06ba3](https://api.epticmc.com/activate?usercode=abc&uuid=22891b6c11954740b240247315f06ba3)

[https://epticmc.com/forum/misc.php?action=activateuser&acode=x](https://epticmc.com/forum/misc.php?action=activateuser&acode=x)
