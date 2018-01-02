# GamBot
Gambling bot for Teamspeak3

### How gamble works?
It works by random color pick. Color is picked trough function and function checks if color match with random color. If yes then u win specific number of points, if not you loose your bet.

### Which colors can I pick?
You can pick 3 colors (RED, BLACK, GREEN). In script I included how much your gonna get if you win and lose. For red and black its x2 for win and for lose its minus bet number. But for green if you win its x14 but chances that u get green are small. If you lose on green its same as others.

### Is script riged?
No, its not. Spin function is 100% random.

### What I can do with this?
If I catch time next week I will make group redeemer. Basically function to get specific group for that number of points. But for now you can use it for testing and fun ^^

### On what commands bot responds?
It responds on:
* **!start**: registers a new channel
* **!bet**: bot opens chat to you and type welcome words (channel chat)
* **!_color_**: bet on a color (ex. !red). You can type !red 10 and that means you bet 10 coins on red color. That stands for all other colors. (private chat)
* **!status**: TO DO In 3.0v
* **!help**: TO DO In 3.0v
* **!redeem**: TO DO In 3.0v

### Can I customize win rates and other?
That can be done in file config.php
Its all explained in that file.

### What languages bot responds on?
For now it responds on english and bosnian.
But you can always make translate and add it to lang.php

### How to start GamBot?
Open terminal and write ./gambot.sh start to start script or
```bash
./gambot.sh stop to stop bot from running forever.
```
