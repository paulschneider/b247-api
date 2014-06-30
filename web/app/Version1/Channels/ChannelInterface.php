<?php namespace Version1\Channels;

Interface ChannelInterface
{
    public function getChannels();

    public function getChannelList();

    public function getChannel($id);

    public function getSimpleChannels($id);

    public function getSimpleSubChannels();

    public function getChannelByIdentifier($identifier);

    public function storeChannel($form);
}
