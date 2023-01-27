# Twitch Chatters

![Twitch Chatters](https://i.postimg.cc/503SnnX5/Chatters.png)

## About

Twitch Chatters simply shows a list of Twitch chatters extrated from Twitch TMI API. No authentication is required.

## Getting started

Host it in your own PHP (7.5+) webserver and use the URL parameter `channel=your_twitch_channel_name` to get started.
It can be easily integrated with OBS as a Browser Dock via `Docks > Custom Browser Docks` menu. It also beeps when someone gets in/out.
If you don't know how to add a Custom Browser Dock, check this tutorial from `Activater`: https://youtu.be/ItFeV8TimxE?t=82

## URL Parameters

- `channel` Twitch Channel Username
- `disable_beep` Disables tiny beeps when people gets in/out
- `refresh_time` Time (in seconds) the page will reload to update the list
- `bg_color` Changes the app background color to match your OBS template
- `text_color` Changes the app text color to match your OBS template

## Example

`https://mywebsite.com/twitch-chatters/?channel=xqc`