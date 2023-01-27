# Twitch Chatters

## About

Twitch Chatters simply shows a list of Twitch chatters extrated from Twitch TMI API. No authentication is required.
It can be easily integrated with OBS as a Browser Dock. It also beeps when someone gets in/out.

## Getting started

Host it in your own PHP (7.5+) webserver and use the URL parameter `channel=your_twitch_channel_name` to get started.

## URL Parameters

`channel` Twitch Channel Username
`disable_beep` Disables tiny beeps when people gets in/out
`bg_color` Changes the app background color to match your OBS template
`text_color` Changes the app text color to match your OBS template

## Example

`https://mywebsite.com/twitch-chatters/?channel=xqc`