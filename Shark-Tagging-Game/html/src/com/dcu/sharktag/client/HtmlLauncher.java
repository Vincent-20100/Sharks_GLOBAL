package com.dcu.sharktag.client;

import com.badlogic.gdx.ApplicationListener;
import com.badlogic.gdx.backends.gwt.GwtApplication;
import com.badlogic.gdx.backends.gwt.GwtApplicationConfiguration;
import com.dcu.sharktag.SharkTag;

public class HtmlLauncher extends GwtApplication {

        @Override
        public GwtApplicationConfiguration getConfig () {
                return new GwtApplicationConfiguration(854, 480);
        }

        @Override
        public ApplicationListener getApplicationListener () {
                return new SharkTag();
        }
}