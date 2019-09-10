<!DOCTYPE html>
<html>
  <head>
        <meta charset="utf-8" /> 
    <link href="https://cdn.botframework.com/botframework-webchat/latest/botchat.css" rel="stylesheet" />
  </head>
  <body>
    <div id="bot">
        bot go here
        </div>
    <script src="https://cdn.botframework.com/botframework-webchat/latest/botchat.js"></script>
    <script src="https://cdn.botframework.com/botframework-webchat/latest/CognitiveServices.js"></script>

   
    <script>

     const speechOptions = {
         speechRecognizer: new BotChat.Speech.BrowserSpeechRecognizer(),
         //speechSynthesizer: new BotChat.Speech.BrowserSpeechSynthesizer()
      };


      BotChat.App({
        directLine: { secret: '-M8ZlCY55Fg.cwA.vRs.Gi5LaEQOI7uy5G6Y83qIdfQTwI5H25hDnsj30pdgOjM' },
        user: { id: 'userid' },
        bot: { id: 'botid' },
        locale : 'en',
        speechOptions: speechOptions,
        resize: 'detect'
      }, document.getElementById("bot"));

     
    </script>
  </body>

  <style>
  .wc-message-content{
   
    box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
    transition: all 0.3s cubic-bezier(.25,.8,.25,1);
  }
  .wc-message-content:hover{
    box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
  }
  .wc-header{
      background-color:white;
      box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
      text-align: center;
      color: grey;
  }
  .ac-image{
  	
  }
  </style>
</html>