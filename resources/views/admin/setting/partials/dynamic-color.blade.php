<style>
    :root {
        @if(getOption('app_color_design_type', DEFAULT_COLOR) == DEFAULT_COLOR)
        --sidebar-text: #0e191e;
        --sidebar-active: #f6f6f6;
        --button: #ff521c;
        --badge-open-text: #ff521c;

        @else
        --sidebar-text: {{ getOption('sidebar_color','#0e191e') }};
        --sidebar-active: {{ getOption('sidebar_active_color','#f6f6f6') }};
        --button: {{ getOption('main_color','#ff521c') }};
        --badge-open-text : {{ getOption('main_color','#ff521c') }};

    @endif

--white: #ffffff;
        --white-5: rgb(255, 255, 255, 0.05);
        --white-10: rgb(255, 255, 255, 0.1);
        --white-12: rgb(255, 255, 255, 0.12);
        --white-15: rgb(255, 255, 255, 0.15);
        --white-20: rgb(255, 255, 255, 0.2);
        --white-60: rgb(255, 255, 255, 0.6);
        --white-70: rgb(255, 255, 255, 0.7);
        --white-80: rgb(255, 255, 255, 0.8);
        --black: #000000;
        --button-5: rgba(255, 82, 28, 0.05);
        --button-16: rgba(255, 82, 28, 0.16);
        --title-text: #0e191e;
        --para-text: #5b5b5b;
        --white-para: #cfd1d2;
        --frame: #f6f6f6;
        --stroke: #f5f5f5;
        --black-stroke: #e7e8e8;
        --white-stroke: #3c4548;
        --bg: #fff9ee;
        --icon-color: #103e13;
        --frame-border: #f2f2f2;
        --process-one: #1a2529;
        --scroll-track: #efefef;
        --scroll-thumb: #dadada;
        --title-text-10: rgba(14, 25, 30, 0.1);
        --neutrals-100: #e8ebed;
        --warning-50: #fefce8;
        --success-500: #22c55e;
        --success-100: #dcfce7;
    }
    .theme-two {
        @if(getOption('app_color_design_type', DEFAULT_COLOR) == DEFAULT_COLOR)
        --button: #4caf4f;
        --badge-open-text: #4caf4f;
        @else
        --button: {{ getOption('main_color','#4caf4f') }};
        --badge-open-text: {{ getOption('main_color','#4caf4f') }};
        @endif
        --button-5: rgba(76, 175, 79, 0.05);
        --button-16: rgba(76, 175, 79, 0.16);
        --title-text: #263238;
        --para-text: #717171;
        --white-para: #bec1c3;
        --frame: #f5f7fa;
        --black-stroke: #e0e2e5;
        --white-stroke: #747c80;
        --bg: #f5f7fa;
        --process-one: #3b464c;
    }

    .theme-three {
        @if(getOption('app_color_design_type', DEFAULT_COLOR) == DEFAULT_COLOR)
        --button: #794aff;
        --badge-open-text: #794aff;
        @else
        --button: {{ getOption('main_color','#794aff') }};
        --badge-open-text: {{ getOption('main_color','#4caf4f') }};

        @endif
        --button: #794aff;
        --button-5: rgba(121, 74, 255, 0.05);
        --button-16: rgba(121, 74, 255, 0.16);
        --title-text: #101828;
        --para-text: #70747e;
        --white-para: #cfd1d4;
        --frame: #f9fafb;
        --black-stroke: #e2e3e6;
        --white-stroke: #3e4451;
        --bg: #ffffff;
    }
</style>
