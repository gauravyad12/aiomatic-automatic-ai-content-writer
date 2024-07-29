"use strict";
var selectedImage = '';
if(wp.media !== undefined && wp.media.view !== undefined && wp.media.view.l10n !== undefined)
{
    var l10n = wp.media.view.l10n;
    wp.media.view.MediaFrame.Select.prototype.browseRouter = function( routerView ) {
        routerView.set({
            upload: {
                text:     l10n.uploadFilesTitle,
                priority: 20
            },
            browse: {
                text:     l10n.mediaLibraryTitle,
                priority: 40
            },
            aiomatic_tab: {
                text:     "Aiomatic Royalty Free Images",
                priority: 80,
                className: 'media-menu-item menu-item-aiomatic_royalty_tab'
            },
            aiomatic_royalty_tab: {
                text:     "Aiomatic AI Generated Images",
                priority: 90,
                className: 'media-menu-item menu-item-aiomatic_tab'
            }
        });
    };
}
jQuery(document).ready(function($){
    if ( wp.media ) 
    {
        wp.media.view.Modal.prototype.on( "open", function() 
        {
            if($('body').find('.menu-item-aiomatic_tab')[0] !== undefined)
            {
                if($('body').find('.menu-item-aiomatic_tab')[0].classList.contains('active'))
                {
                    AiomaticDoMyTabContent();
                }
                $('.menu-item-aiomatic_tab').on('click', function(e){
                    AiomaticDoMyTabContent();
                });
            }
            if($('body').find('.menu-item-aiomatic_royalty_tab')[0] !== undefined)
            {
                if($('body').find('.menu-item-aiomatic_royalty_tab')[0].classList.contains('active'))
                {
                    AiomaticDoMyTabRoyaltyContent();
                }
                $('.menu-item-aiomatic_royalty_tab').on('click', function(e){
                    AiomaticDoMyTabRoyaltyContent();
                });
            }
        });
    }
    if($(".aiomatic-image-tab-1").length != 0) {
        AiomaticDoMyTabContent();
    }
    if($(".aiomatic-image-tab-2").length != 0) {
        AiomaticDoMyTabRoyaltyContent();
    }
});
function AiomaticDoMyTabContent() 
{
    var aimodels = '<option value="openai" selected>OpenAI Dall-E 2</option><option value="dalle3">OpenAI Dall-E 3</option><option value="dalle3hd">OpenAI Dall-E 3 HD</option>';
    if(aiomatic_img_ajax_object.no_stable != '1')
    {
        aimodels += '<option value="stable">Stable Difussion</option>';
    }
    if(aiomatic_img_ajax_object.no_midjourney != '1')
    {
        aimodels += '<option value="midjourney">Midjourney</option>';
    }
    var html = `
<div id="aiomatic-block-editor" class="aiomatic-block-editor">
    <figure class="block-editor-block-list__block wp-block is-selected wp-block-uploads-aiomatic" style="display: block;margin-block-start: 1em;margin-block-end: 1em;margin-inline-start: 40px;margin-inline-end: 40px;width:auto;max-width:100%">
        <div>
            <fieldset>
                <h4>Generate AI images in seconds, based on your prompts or style options:</h4>
                <div class="aiomatic-image-result cr_image_center" id="aiomatic_image_div"><img id="aiomatic_ai_image_response" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+ip1sAAAAASUVORK5CYII="></div>
                <div class="aiomatic-image-div" id="aiomatic-image-upload" style="display:none;">
                    <button type="button" id="aiomatic_image_upload" class="button load-more button-primary" onclick="aiomatic_upload_images();"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true" focusable="false"><path d="M18.5 15v3.5H13V6.7l4.5 4.1 1-1.1-6.2-5.8-5.8 5.8 1 1.1 4-4v11.7h-6V15H4v5h16v-5z"></path></svg>&nbsp;Save to Media Library</button>
                    <br/><br/>
                </div>
                <div class="aiomatic-prompt-form">
                    <label for="aiomatic-textarea-control">AI Image Prompt: enter a detailed description of the image you would like to generate, for more about how to get the most out of created images, check this <a href="https://coderevolution.ro/knowledge-base/faq/basics-of-ai-prompt-engineering-for-best-quality-images/" target="_blank">prompt guide</a>.</label>
                    <textarea style="width:100%;max-width:100%" id="aiomatic-textarea-control" rows="2" maxlength="450" placeholder="Your image prompt here"></textarea>
                </div>
                <div class="aiomatic-styles-form">
                    <div>
                        <label>Select an image style</label>
                    </div>
                    <div>
                        <select id="aiomatic-image-style" style="width:100%;max-width:100%">
                            <option selected value="" disabled>Select a value...</option>
                            <option value="painting, digital art, trending on artstation">Painting</option>
                            <option value="digital art, trending on artstation, hd">&nbsp;&nbsp;&nbsp;Digital Art</option>
                            <option value="oil painting, award winning">&nbsp;&nbsp;&nbsp;Oil Painting</option>
                            <option value="watercolor painting">&nbsp;&nbsp;&nbsp;Watercolor</option>
                            <option value="acrylic painting, award winning art, trending">&nbsp;&nbsp;&nbsp;Acrylic</option>
                            <option value="airbrush art">&nbsp;&nbsp;&nbsp;Airbrushed</option>
                            <option value="comic, comic book">&nbsp;&nbsp;&nbsp;Comic Book</option>
                            <option value="schematic blueprint">&nbsp;&nbsp;&nbsp;Blueprint</option>
                            <option value="made up of ink dots, artistic drawing, trending on artstation">&nbsp;&nbsp;&nbsp;Ink Dot</option>
                            <option value="artistic drawing, trending on artstation">Drawing</option>
                            <option value="illustration, trending on artstation">&nbsp;&nbsp;&nbsp;Illustration</option>
                            <option value="cyberpunk, trending on artstation">&nbsp;&nbsp;&nbsp;Cyberpunk</option>
                            <option value="pencil sketch, drawing, trending on artstation">&nbsp;&nbsp;&nbsp;Pencil</option>
                            <option value="drawn in blue biro pen, artistic drawing, trending on artstation">&nbsp;&nbsp;&nbsp;Pen</option>
                            <option value="Ink dripping drawing, trending on artstation">&nbsp;&nbsp;&nbsp;Ink</option>
                            <option value="caligraphy">&nbsp;&nbsp;&nbsp;Caligraphy</option>
                            <option value="charcoal shaded, artistic drawing, trending on artstation">&nbsp;&nbsp;&nbsp;Charcoal</option>
                            <option value="cartoon">&nbsp;&nbsp;&nbsp;Cartoon</option>
                            <option value="comic, comic book">&nbsp;&nbsp;&nbsp;Comic Book</option>
                            <option value="schematic blueprint">&nbsp;&nbsp;&nbsp;Blueprint</option>
                            <option value="technical sketch">&nbsp;&nbsp;&nbsp;Technical Sketch</option>
                            <option value="made up of ink dots, artistic drawing, trending on artstation">&nbsp;&nbsp;&nbsp;Ink Dot</option>
                            <option value="line art">&nbsp;&nbsp;&nbsp;Line Art</option>
                            <option value="crayon drawing">&nbsp;&nbsp;&nbsp;Crayon</option>
                            <option value="pastel drawing, artistic">&nbsp;&nbsp;&nbsp;Pastel</option>
                            <option value="chalkboard drawing">&nbsp;&nbsp;&nbsp;Chalkboard</option>
                            <option value="animation">Animation</option>
                            <option value="vintage disney animation">&nbsp;&nbsp;&nbsp;Vintage Disney</option>
                            <option value="Rendered by octane, disney animation studios">&nbsp;&nbsp;&nbsp;Disney Animation</option>
                            <option value="simpsons style animation">&nbsp;&nbsp;&nbsp;Simpsons</option>
                            <option value="anime style, Studio Ghibli, manga, trending on artstation">&nbsp;&nbsp;&nbsp;Anime</option>
                            <option value="disney pixar style animation, octane render">&nbsp;&nbsp;&nbsp;Pixar</option>
                            <option value="unreal engine, 3d render, Rendered by octane">Screen</option>
                            <option value="Unreal Engine, Cinema 4D">&nbsp;&nbsp;&nbsp;Video Game HD</option>
                            <option value="animal crossing, mario, nintendo, pokemon">&nbsp;&nbsp;&nbsp;Nintendo</option>
                            <option value="3D render, composite">&nbsp;&nbsp;&nbsp;3D Render</option>
                            <option value="8bit graphics">&nbsp;&nbsp;&nbsp;8bit</option>
                            <option value="emoji">&nbsp;&nbsp;&nbsp;Emoji</option>
                            <option value="low poly ps1 graphics">&nbsp;&nbsp;&nbsp;Low Poly</option>
                            <option value="pixel art">&nbsp;&nbsp;&nbsp;Pixel Art</option>
                            <option value="ASCII art">&nbsp;&nbsp;&nbsp;ASCII</option>
                            <option value="photograph of, photo, 50mm portrait photograph">Photography (avoid people)</option>
                            <option value="realistic photo of, award winning photograph, 50mm">&nbsp;&nbsp;&nbsp;Realistic</option>
                            <option value="Portrait photograph, symmetrical, award winning, bokeh, dof, Annie Leibovitz">&nbsp;&nbsp;&nbsp;Portrait</option>
                            <option value="polaroid photograph, polaroid frame">&nbsp;&nbsp;&nbsp;Polaroid</option>
                            <option value="war photograph, WWI photograph, WWII photograph">&nbsp;&nbsp;&nbsp;War</option>
                            <option value="Wildlife Photograph, national geographic photo, zoom, telephoto">&nbsp;&nbsp;&nbsp;Wildlife</option>
                            <option value="Photojournalism, award winning, photo of, magazine photograph">&nbsp;&nbsp;&nbsp;Photojournalism</option>
                            <option value="macro photograph, close up, zoom, depth of field">&nbsp;&nbsp;&nbsp;Macro</option>
                            <option value="long exposure, photograph, realistic">&nbsp;&nbsp;&nbsp;Long Exposure</option>
                            <option value="photograph, fish eye lense, wide-angle">&nbsp;&nbsp;&nbsp;Fish Eye</option>
                            <option value="realistic">Real Life Materials</option>
                            <option value="statue">&nbsp;&nbsp;&nbsp;Statue</option>
                            <option value="marble statue">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Marble</option>
                            <option value="stone statue">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;stone</option>
                            <option value="statue carved from wax">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Wax</option>
                            <option value="origami paper folding">&nbsp;&nbsp;&nbsp;Origami</option>
                            <option value="paper mache art">&nbsp;&nbsp;&nbsp;Paper Mache</option>
                            <option value="paper cutout art">&nbsp;&nbsp;&nbsp;Paper Cutout</option>
                            <option value="graffiti street art">&nbsp;&nbsp;&nbsp;Graffiti</option>
                            <option value="halftone print">&nbsp;&nbsp;&nbsp;Halftone</option>
                            <option value="cross stitch art">&nbsp;&nbsp;&nbsp;Cross Stitch</option>
                            <option value="stained glass">&nbsp;&nbsp;&nbsp;Stained Glass</option>
                            <option value="made of crystals">&nbsp;&nbsp;&nbsp;Crystal</option>
                            <option value="made of flowers">&nbsp;&nbsp;&nbsp;Flowery</option>
                            <option value="Style: Surrealism">Surrealism</option><option value="Style: Abstract">Abstract</option><option value="Style: Abstract Expressionism">Abstract Expressionism</option><option value="Style: Action painting">Action painting</option><option value="Style: Art Brut">Art Brut</option>
                            <option value="Style: Art Deco">Art Deco</option><option value="Style: Art Nouveau">Art Nouveau</option><option value="Style: Baroque">Baroque</option><option value="Style: Byzantine">Byzantine</option><option value="Style: Classical">Classical</option><option value="Style: Color Field">Color Field</option>
                            <option value="Style: Conceptual">Conceptual</option><option value="Style: Cubism">Cubism</option><option value="Style: Dada">Dada</option><option value="Style: Expressionism">Expressionism</option><option value="Style: Fauvism">Fauvism</option><option value="Style: Figurative">Figurative</option>
                            <option value="Style: Futurism">Futurism</option>
                            <option value="Style: Gothic">Gothic</option><option value="Style: Hard-edge painting">Hard-edge painting</option><option value="Style: Hyperrealism">Hyperrealism</option><option value="Style: Impressionism">Impressionism</option><option value="Style: Japonisme">Japonisme</option>
                            <option value="Style: Luminism">Luminism</option><option value="Style: Lyrical Abstraction">Lyrical Abstraction</option><option value="Style: Mannerism">Mannerism</option><option value="Style: Minimalism">Minimalism</option><option value="Style: Naive Art">Naive Art</option>
                            <option value="Style: New Realism">New Realism</option><option value="Style: Neo-expressionism">Neo-expressionism</option><option value="Style: Neo-pop">Neo-pop</option><option value="Style: Op Art">Op Art</option><option value="Style: Opus Anglicanum">Opus Anglicanum</option>
                            <option value="Style: Outsider Art">Outsider Art</option><option value="Style: Pop Art">Pop Art</option><option value="Style: Photorealism">Photorealism</option><option value="Style: Pointillism">Pointillism</option>
                            <option value="Style: Post-Impressionism">Post-Impressionism</option><option value="Style: Realism">Realism</option><option value="Style: Renaissance">Renaissance</option><option value="Style: Rococo">Rococo</option><option value="Style: Romanticism">Romanticism</option>
                            <option value="Style: Street Art">Street Art</option><option value="Style: Superflat">Superflat</option><option value="Style: Symbolism">Symbolism</option><option value="Style: Tenebrism">Tenebrism</option><option value="Style: Ukiyo-e">Ukiyo-e</option><option value="Style: Western Art">Western Art</option>
                            <option value="Style: YBA">YBA</option>
                        </select>
                    </div>
                    <div>
                        <label for="aiomatic-artist-style">Select an Artist style</label>
                    </div>
                    <div>
                        <select id="aiomatic-artist-style" style="width:100%;max-width:100%">
                            <option selected value="" disabled>Select a value...</option>
                            <option value="Artist: Salvador Dalí">Salvador Dalí</option><option value="Artist: Leonardo da Vinci">Leonardo da Vinci</option><option value="Artist: Michelangelo">Michelangelo</option><option value="Artist: Albrecht Dürer">Albrecht Dürer</option><option value="Artist: Alfred Sisley">Alfred Sisley</option><option value="Artist: Andrea Mantegna">Andrea Mantegna</option><option value="Artist: Andy Warhol">Andy Warhol</option><option value="Artist: Amedeo Modigliani">Amedeo Modigliani</option><option value="Artist: Camille Pissarro">Camille Pissarro</option><option value="Artist: Caravaggio">Caravaggio</option><option value="Artist: Caspar David Friedrich">Caspar David Friedrich</option><option value="Artist: Cézanne">Cézanne</option>
                            <option value="Artist: Claude Monet">Claude Monet</option><option value="Artist: Diego Velázquez">Diego Velázquez</option><option value="Artist: Eugène Delacroix">Eugène Delacroix</option><option value="Artist: Frida Kahlo">Frida Kahlo</option><option value="Artist: Gustav Klimt">Gustav Klimt</option><option value="Artist: Henri Matisse">Henri Matisse</option><option value="Artist: Henri de Toulouse-Lautrec">Henri de Toulouse-Lautrec</option><option value="Artist: Jackson Pollock">Jackson Pollock</option><option value="Artist: Jasper Johns">Jasper Johns</option><option value="Artist: Joan Miró">Joan Miró</option><option value="Artist: John Singer Sargent">John Singer Sargent</option><option value="Artist: Johannes Vermeer">Johannes Vermeer</option><option value="Artist: Mary Cassatt">Mary Cassatt</option>
                            <option value="Artist: M. C. Escher">M. C. Escher</option><option value="Artist: Paul Cézanne">Paul Cézanne</option><option value="Artist: Paul Gauguin">Paul Gauguin</option>
                            <option value="Artist: Paul Klee">Paul Klee</option><option value="Artist: Pierre-Auguste Renoir">Pierre-Auguste Renoir</option><option value="Artist: Pieter Bruegel the Elder">Pieter Bruegel the Elder</option><option value="Artist: Piet Mondrian">Piet Mondrian</option><option value="Artist: Pablo Picasso">Pablo Picasso</option><option value="Artist: Rembrandt">Rembrandt</option><option value="Artist: René Magritte">René Magritte</option><option value="Artist: Raphael">Raphael</option><option value="Artist: Sandro Botticelli">Sandro Botticelli</option><option value="Artist: Titian">Titian</option><option value="Artist: Theo van Gogh">Theo van Gogh</option><option value="Artist: Vincent van Gogh">Vincent van Gogh</option><option value="Artist: Vassily Kandinsky">Vassily Kandinsky</option><option value="Artist: Winslow Homer">Winslow Homer</option>
                            <option value="by Albert Bierstadt">Albert Bierstadt</option>
                            <option value="by Asaf Hanuka">Asaf Hanuka</option>
                            <option value="by Aubrey Beardsley">Aubrey Beardsley</option>
                            <option value="by Diego Rivera">Diego Rivera</option>
                            <option value="by Greg Rutkowski">Greg Rutkowski</option>
                            <option value="by Hayao Miyazaki">Hayao Miyazaki</option>
                            <option value="by Hieronymus Bosch">Hieronymus Bosch</option>
                            <option value="by artgerm, art germ">Stanley Artgerm</option>
                            <option value="by Thomas Kinkade">Thomas Kinkade</option>
                        </select>
                    </div>
                    <div>
                        <label for="aiomatic-style-modifier">Select a style modifier</label>
                    </div>
                    <div>
                        <select id="aiomatic-style-modifier" style="width:100%;max-width:100%">
                            <option selected value="" disabled>Select a value...</option>
                            <option value="in the style of steampunk">Steampunk</option>
                            <option value="synthwave">Synthwave</option>
                            <option value="in the style of cyberpunk">Cyberpunk</option>
                            <option value="insanely detailed and intricate, hypermaximalist, elegant, ornate, hyper realistic, super detailed">Detailed &amp; Intricate</option>
                            <option value="in a symbolic and meaningful style, insanely detailed and intricate, hypermaximalist, elegant, ornate, hyper realistic, super detailed">Symbolic &amp; Meaningful</option>
                            <option value="Cinematic Lighting">Cinematic Lighting</option>
                            <option value="Contre-Jour">Contre-Jour</option>
                            <option value="futuristic">Futuristic</option>
                            <option value="black and white">Black &amp; White</option>
                            <option value="technicolor">Technicolor</option>
                            <option value="warm color palette">Warm</option>
                            <option value="neon">Neon</option>
                            <option value="colorful">Colorful</option>
                        </select>
                    </div>
                    <div>
                        <label for="aiomatic-photography-modifier">Select a photography type</label>
                    </div>
                    <div>
                        <select id="aiomatic-photography-modifier" style="width:100%;max-width:100%">
                            <option selected value="" disabled>Select a value...</option>
                            <option value="Photography: Portrait">Portrait</option><option value="Photography: Landscape">Landscape</option><option value="Photography: Abstract">Abstract</option><option value="Photography: Action">Action</option><option value="Photography: Aerial">Aerial</option><option value="Photography: Agricultural">Agricultural</option><option value="Photography: Animal">Animal</option><option value="Photography: Architectural">Architectural</option><option value="Photography: Artistic">Artistic</option><option value="Photography: Astrophotography">Astrophotography</option><option value="Photography: Bird photography">Bird photography</option><option value="Photography: Black and white">Black and white</option><option value="Photography: Candid">Candid</option><option value="Photography: Cityscape">Cityscape</option><option value="Photography: Close-up">Close-up</option><option value="Photography: Commercial">Commercial</option><option value="Photography: Conceptual">Conceptual</option>
                            <option value="Photography: Corporate">Corporate</option><option value="Photography: Documentary">Documentary</option><option value="Photography: Event">Event</option><option value="Photography: Family">Family</option><option value="Photography: Fashion">Fashion</option><option value="Photography: Fine art">Fine art</option><option value="Photography: Food">Food</option><option value="Photography: Food photography">Food photography</option><option value="Photography: Glamour">Glamour</option><option value="Photography: Industrial">Industrial</option><option value="Photography: Lifestyle">Lifestyle</option><option value="Photography: Macro">Macro</option><option value="Photography: Nature">Nature</option><option value="Photography: Night">Night</option><option value="Photography: Product">Product</option><option value="Photography: Sports">Sports</option><option value="Photography: Street">Street</option><option value="Photography: Travel">Travel</option><option value="Photography: Underwater">Underwater</option><option value="Photography: Wedding">Wedding</option><option value="Photography: Wildlife">Wildlife</option>
                        </select>
                    </div>
                    <div>
                        <label for="aiomatic-lighting-modifier">Select a lighting type</label>
                    </div>
                    <div>
                        <select id="aiomatic-lighting-modifier" style="width:100%;max-width:100%">
                            <option selected value="" disabled>Select a value...</option>
                            <option value="Lighting: Ambient">Ambient</option><option value="Lighting: Artificial light">Artificial light</option><option value="Lighting: Backlight">Backlight</option><option value="Lighting: Black light">Black light</option><option value="Lighting: Blue hour">Blue hour</option><option value="Lighting: Candle light">Candle light</option><option value="Lighting: Chiaroscuro">Chiaroscuro</option><option value="Lighting: Cloudy">Cloudy</option><option value="Lighting: Color gels">Color gels</option><option value="Lighting: Continuous light">Continuous light</option><option value="Lighting: Contre-jour">Contre-jour</option><option value="Lighting: Direct light">Direct light</option><option value="Lighting: Direct sunlight">Direct sunlight</option><option value="Lighting: Diffused light">Diffused light</option><option value="Lighting: Firelight">Firelight</option><option value="Lighting: Flash">Flash</option><option value="Lighting: Flat light">Flat light</option><option value="Lighting: Fluorescent">Fluorescent</option><option value="Lighting: Fog">Fog</option><option value="Lighting: Front light">Front light</option><option value="Lighting: Golden hour">Golden hour</option><option value="Lighting: Hard light">Hard light</option><option value="Lighting: Hazy sunlight">Hazy sunlight</option><option value="Lighting: High key">High key</option><option value="Lighting: Incandescent">Incandescent</option>
                            <option value="Lighting: Key light">Key light</option><option value="Lighting: LED">LED</option><option value="Lighting: Low key">Low key</option><option value="Lighting: Moonlight">Moonlight</option><option value="Lighting: Natural light">Natural light</option><option value="Lighting: Neon">Neon</option><option value="Lighting: Open shade">Open shade</option><option value="Lighting: Overcast">Overcast</option><option value="Lighting: Paramount">Paramount</option><option value="Lighting: Party lights">Party lights</option><option value="Lighting: Photoflood">Photoflood</option><option value="Lighting: Quarter light">Quarter light</option><option value="Lighting: Reflected light">Reflected light</option><option value="Lighting: Rim light">Rim light</option><option value="Lighting: Shaded">Shaded</option><option value="Lighting: Shaded light">Shaded light</option><option value="Lighting: Silhouette">Silhouette</option><option value="Lighting: Side light">Side light</option><option value="Lighting: Single-source">Single-source</option><option value="Lighting: Softbox">Softbox</option><option value="Lighting: Soft light">Soft light</option><option value="Lighting: Split lighting">Split lighting</option>
                            <option value="Lighting: Stage lighting">Stage lighting</option><option value="Lighting: Studio light">Studio light</option><option value="Lighting: Sunburst">Sunburst</option><option value="Lighting: Tungsten">Tungsten</option><option value="Lighting: Umbrella lighting">Umbrella lighting</option><option value="Lighting: Underexposed">Underexposed</option><option value="Lighting: Venetian blinds">Venetian blinds</option><option value="Lighting: Warm light">Warm light</option><option value="Lighting: White balance">White balance</option>
                            </select>
                    </div>
                    <div>
                        <label for="aiomatic-subject-modifier">Select a subject type</label>
                    </div>
                    <div>
                        <select id="aiomatic-subject-modifier" style="width:100%;max-width:100%">
                        <option selected value="" disabled>Select a value...</option>
                        <option value="Subject: Landscapes">Landscapes</option><option value="Subject: People">People</option><option value="Subject: Animals">Animals</option><option value="Subject: Food">Food</option><option value="Subject: Cars">Cars</option><option value="Subject: Architecture">Architecture</option><option value="Subject: Flowers">Flowers</option><option value="Subject: Still life">Still life</option><option value="Subject: Portrait">Portrait</option><option value="Subject: Cityscapes">Cityscapes</option><option value="Subject: Seascapes">Seascapes</option><option value="Subject: Nature">Nature</option><option value="Subject: Action">Action</option><option value="Subject: Events">Events</option><option value="Subject: Street">Street</option><option value="Subject: Abstract">Abstract</option><option value="Subject: Candid">Candid</option><option value="Subject: Underwater">Underwater</option><option value="Subject: Night">Night</option><option value="Subject: Wildlife">Wildlife</option>
                        </select>
                    </div>
                    <div>
                        <label for="aiomatic-camera-modifier">Select a camera type</label>
                    </div>
                    <div>
                        <select id="aiomatic-camera-modifier" style="width:100%;max-width:100%">
                        <option selected value="" disabled>Select a value...</option>
                        <option value="Camera: Aperture">Aperture</option><option value="Camera: Active D-Lighting">Active D-Lighting</option><option value="Camera: Auto Exposure Bracketing">Auto Exposure Bracketing</option><option value="Camera: Auto Focus Mode">Auto Focus Mode</option><option value="Camera: Auto Focus Point">Auto Focus Point</option><option value="Camera: Auto Lighting Optimizer">Auto Lighting Optimizer</option><option value="Camera: Auto Rotate">Auto Rotate</option><option value="Camera: Aspect Ratio">Aspect Ratio</option><option value="Camera: Audio Recording">Audio Recording</option><option value="Camera: Auto ISO">Auto ISO</option><option value="Camera: Chromatic Aberration Correction">Chromatic Aberration Correction</option><option value="Camera: Color Space">Color Space</option><option value="Camera: Continuous Shooting">Continuous Shooting</option><option value="Camera: Distortion Correction">Distortion Correction</option><option value="Camera: Drive Mode">Drive Mode</option><option value="Camera: Dynamic Range">Dynamic Range</option><option value="Camera: Exposure Compensation">Exposure Compensation</option><option value="Camera: Flash Mode">Flash Mode</option><option value="Camera: Focus Mode">Focus Mode</option><option value="Camera: Focus Peaking">Focus Peaking</option><option value="Camera: Frame Rate">Frame Rate</option><option value="Camera: GPS">GPS</option><option value="Camera: Grid Overlay">Grid Overlay</option><option value="Camera: High Dynamic Range">High Dynamic Range</option>
                        <option value="Camera: Highlight Tone Priority">Highlight Tone Priority</option><option value="Camera: Image Format">Image Format</option><option value="Camera: Image Stabilization">Image Stabilization</option><option value="Camera: Interval Timer Shooting">Interval Timer Shooting</option><option value="Camera: ISO">ISO</option><option value="Camera: ISO Auto Setting">ISO Auto Setting</option><option value="Camera: Lens Correction">Lens Correction</option><option value="Camera: Live View">Live View</option><option value="Camera: Long Exposure Noise Reduction">Long Exposure Noise Reduction</option><option value="Camera: Manual Focus">Manual Focus</option><option value="Camera: Metering Mode">Metering Mode</option><option value="Camera: Movie Mode">Movie Mode</option><option value="Camera: Movie Quality">Movie Quality</option><option value="Camera: Noise Reduction">Noise Reduction</option><option value="Camera: Picture Control">Picture Control</option><option value="Camera: Picture Style">Picture Style</option><option value="Camera: Quality">Quality</option><option value="Camera: Self-Timer">Self-Timer</option><option value="Camera: Shutter Speed">Shutter Speed</option><option value="Camera: Time-lapse Interval">Time-lapse Interval</option><option value="Camera: Time-lapse Recording">Time-lapse Recording</option><option value="Camera: Virtual Horizon">Virtual Horizon</option><option value="Camera: Video Format">Video Format</option><option value="Camera: White Balance">White Balance</option><option value="Camera: Zebra Stripes">Zebra Stripes</option>
                        </select>
                    </div>
                    <div>
                        <label for="aiomatic-composition-modifier">Select a composition type</label>
                    </div>
                    <div>
                        <select id="aiomatic-composition-modifier" style="width:100%;max-width:100%">
                        <option selected value="" disabled>Select a value...</option>
                        <option value="Composition: Rule of Thirds">Rule of Thirds</option><option value="Composition: Asymmetrical">Asymmetrical</option><option value="Composition: Balance">Balance</option><option value="Composition: Centered">Centered</option><option value="Composition: Close-up">Close-up</option><option value="Composition: Color blocking">Color blocking</option><option value="Composition: Contrast">Contrast</option><option value="Composition: Cropping">Cropping</option><option value="Composition: Diagonal">Diagonal</option><option value="Composition: Documentary">Documentary</option><option value="Composition: Environmental Portrait">Environmental Portrait</option><option value="Composition: Fill the Frame">Fill the Frame</option><option value="Composition: Framing">Framing</option><option value="Composition: Golden Ratio">Golden Ratio</option><option value="Composition: High Angle">High Angle</option><option value="Composition: Leading Lines">Leading Lines</option><option value="Composition: Long Exposure">Long Exposure</option><option value="Composition: Low Angle">Low Angle</option><option value="Composition: Macro">Macro</option><option value="Composition: Minimalism">Minimalism</option><option value="Composition: Negative Space">Negative Space</option><option value="Composition: Panning">Panning</option><option value="Composition: Patterns">Patterns</option><option value="Composition: Photojournalism">Photojournalism</option>
                        <option value="Composition: Point of View">Point of View</option><option value="Composition: Portrait">Portrait</option><option value="Composition: Reflections">Reflections</option><option value="Composition: Saturation">Saturation</option><option value="Composition: Scale">Scale</option><option value="Composition: Selective Focus">Selective Focus</option><option value="Composition: Shallow Depth of Field">Shallow Depth of Field</option><option value="Composition: Silhouette">Silhouette</option><option value="Composition: Simplicity">Simplicity</option><option value="Composition: Snapshot">Snapshot</option><option value="Composition: Street Photography">Street Photography</option><option value="Composition: Symmetry">Symmetry</option><option value="Composition: Telephoto">Telephoto</option><option value="Composition: Texture">Texture</option><option value="Composition: Tilt-Shift">Tilt-Shift</option><option value="Composition: Time-lapse">Time-lapse</option><option value="Composition: Tracking Shot">Tracking Shot</option><option value="Composition: Travel">Travel</option><option value="Composition: Triptych">Triptych</option><option value="Composition: Ultra-wide">Ultra-wide</option><option value="Composition: Vanishing Point">Vanishing Point</option><option value="Composition: Viewpoint">Viewpoint</option><option value="Composition: Vintage">Vintage</option><option value="Composition: Wide Angle">Wide Angle</option>
                        <option value="Composition: Zoom Blur">Zoom Blur</option><option value="Composition: Zoom In/Zoom Out">Zoom In/Zoom Out</option>
                        </select>
                    </div>
                    <div>
                        <label for="aiomatic-resolution-modifier">Select a resolution type</label>
                    </div>
                    <div>
                        <select id="aiomatic-resolution-modifier" style="width:100%;max-width:100%">
                        <option selected value="" disabled>Select a value...</option>
                        <option value="Resolution: 4K (3840x2160)">4K (3840x2160)</option><option value="Resolution: 1080p (1920x1080)">1080p (1920x1080)</option><option value="Resolution: 720p (1280x720)">720p (1280x720)</option><option value="Resolution: 480p (854x480)">480p (854x480)</option><option value="Resolution: 2K (2560x1440)">2K (2560x1440)</option><option value="Resolution: 1080i (1920x1080)">1080i (1920x1080)</option><option value="Resolution: 720i (1280x720)">720i (1280x720)</option>
                        </select>
                    </div>
                    <div>
                        <label for="aiomatic-color-modifier">Select a color type</label>
                    </div>
                    <div>
                        <select id="aiomatic-color-modifier" style="width:100%;max-width:100%">
                        <option selected value="" disabled>Select a value...</option>
                        <option value="Color: RGB">RGB</option><option value="Color: CMYK">CMYK</option><option value="Color: Grayscale">Grayscale</option><option value="Color: HEX">HEX</option><option value="Color: Pantone">Pantone</option><option value="Color: CMY">CMY</option><option value="Color: HSL">HSL</option><option value="Color: HSV">HSV</option><option value="Color: LAB">LAB</option><option value="Color: LCH">LCH</option><option value="Color: LUV">LUV</option><option value="Color: XYZ">XYZ</option><option value="Color: YUV">YUV</option><option value="Color: YIQ">YIQ</option><option value="Color: YCbCr">YCbCr</option><option value="Color: YPbPr">YPbPr</option><option value="Color: YDbDr">YDbDr</option><option value="Color: YCoCg">YCoCg</option><option value="Color: YCgCo">YCgCo</option><option value="Color: YCC">YCC</option>
                        </select>
                    </div>
                    <div>
                        <label for="aiomatic-effects-modifier">Select a special effects type</label>
                    </div>
                    <div>
                        <select id="aiomatic-effects-modifier" style="width:100%;max-width:100%">
                        <option selected value="" disabled>Select a value...</option>
                        <option value="Special Effects: Cinemagraph">Cinemagraph</option><option value="Special Effects: 3D">3D</option><option value="Special Effects: Add Noise">Add Noise</option><option value="Special Effects: Black and White">Black and White</option><option value="Special Effects: Blur">Blur</option><option value="Special Effects: Bokeh">Bokeh</option><option value="Special Effects: Brightness and Contrast">Brightness and Contrast</option><option value="Special Effects: Camera Shake">Camera Shake</option><option value="Special Effects: Clarity">Clarity</option><option value="Special Effects: Color Balance">Color Balance</option><option value="Special Effects: Color Pop">Color Pop</option><option value="Special Effects: Color Temperature">Color Temperature</option><option value="Special Effects: Cross Processing">Cross Processing</option><option value="Special Effects: Crop and Rotate">Crop and Rotate</option><option value="Special Effects: Dehaze">Dehaze</option><option value="Special Effects: Denoise">Denoise</option><option value="Special Effects: Diffuse Glow">Diffuse Glow</option><option value="Special Effects: Displace">Displace</option><option value="Special Effects: Distort">Distort</option><option value="Special Effects: Double exposure">Double exposure</option><option value="Special Effects: Duotone">Duotone</option><option value="Special Effects: Edge Detection">Edge Detection</option><option value="Special Effects: Emboss">Emboss</option><option value="Special Effects: Exposure">Exposure</option>
                        <option value="Special Effects: Fish Eye">Fish Eye</option><option value="Special Effects: Flare">Flare</option><option value="Special Effects: Flip">Flip</option><option value="Special Effects: Fractalius">Fractalius</option><option value="Special Effects: Glowing Edges">Glowing Edges</option><option value="Special Effects: Gradient Map">Gradient Map</option><option value="Special Effects: Grayscale">Grayscale</option>
                        <option value="Special Effects: Halftone">Halftone</option><option value="Special Effects: HDR">HDR</option><option value="Special Effects: HDR Look">HDR Look</option><option value="Special Effects: High Pass">High Pass</option><option value="Special Effects: Hue and Saturation">Hue and Saturation</option><option value="Special Effects: Impressionist">Impressionist</option><option value="Special Effects: Infrared">Infrared</option><option value="Special Effects: Invert">Invert</option><option value="Special Effects: Lens Correction">Lens Correction</option><option value="Special Effects: Lens flare">Lens flare</option><option value="Special Effects: Lomo Effect">Lomo Effect</option><option value="Special Effects: Motion Blur">Motion Blur</option><option value="Special Effects: Night Vision">Night Vision</option><option value="Special Effects: Oil Painting">Oil Painting</option><option value="Special Effects: Old Photo">Old Photo</option><option value="Special Effects: Orton Effect">Orton Effect</option><option value="Special Effects: Panorama">Panorama</option><option value="Special Effects: Pinch">Pinch</option><option value="Special Effects: Pixelate">Pixelate</option><option value="Special Effects: Polar Coordinates">Polar Coordinates</option><option value="Special Effects: Posterize">Posterize</option><option value="Special Effects: Radial Blur">Radial Blur</option><option value="Special Effects: Rain">Rain</option><option value="Special Effects: Reflect">Reflect</option><option value="Special Effects: Ripple">Ripple</option>
                        <option value="Special Effects: Sharpen">Sharpen</option><option value="Special Effects: Slow motion">Slow motion</option><option value="Special Effects: Stop-motion">Stop-motion</option><option value="Special Effects: Solarize">Solarize</option><option value="Special Effects: Starburst">Starburst</option><option value="Special Effects: Sunburst">Sunburst</option><option value="Special Effects: Timelapse">Timelapse</option>
                        <option value="Special Effects: Tilt-shift">Tilt-shift</option><option value="Special Effects: Vignette">Vignette</option><option value="Special Effects: Zoom blur">Zoom blur</option></select>
                    </div>
                    <div>
                        <label for="aiomatic-size-modifier">Select image size</label>
                    </div>
                    <div>
                        <select id="aiomatic-size-modifier" style="width:100%;max-width:100%">
                            <option value="1024x1024">1024x1024</option>
                            <option selected value="512x512">512x512</option>
                            <option value="256x256">256x256</option>
                        </select>
                    </div>
                    <div>
                        <label for="aiomatic-ai-modifier">Select AI Source</label>
                    </div>
                    <div>
                        <select id="aiomatic-ai-modifier" style="width:100%;max-width:100%" onchange="aiomaticModelChanged();">` + aimodels + `</select>
                    </div>
                </div>
                <br/>
                <div>
                    <button type="button" id="aiomatic_image_get" class="button load-more button-primary" onclick="aiomatic_go_get_images();"><svg style="color: white" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-robot" viewBox="0 0 16 16"> <path d="M6 12.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5ZM3 8.062C3 6.76 4.235 5.765 5.53 5.886a26.58 26.58 0 0 0 4.94 0C11.765 5.765 13 6.76 13 8.062v1.157a.933.933 0 0 1-.765.935c-.845.147-2.34.346-4.235.346-1.895 0-3.39-.2-4.235-.346A.933.933 0 0 1 3 9.219V8.062Zm4.542-.827a.25.25 0 0 0-.217.068l-.92.9a24.767 24.767 0 0 1-1.871-.183.25.25 0 0 0-.068.495c.55.076 1.232.149 2.02.193a.25.25 0 0 0 .189-.071l.754-.736.847 1.71a.25.25 0 0 0 .404.062l.932-.97a25.286 25.286 0 0 0 1.922-.188.25.25 0 0 0-.068-.495c-.538.074-1.207.145-1.98.189a.25.25 0 0 0-.166.076l-.754.785-.842-1.7a.25.25 0 0 0-.182-.135Z" fill="white"></path> <path d="M8.5 1.866a1 1 0 1 0-1 0V3h-2A4.5 4.5 0 0 0 1 7.5V8a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1v1a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-1a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1v-.5A4.5 4.5 0 0 0 10.5 3h-2V1.866ZM14 7.5V13a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V7.5A3.5 3.5 0 0 1 5.5 4h5A3.5 3.5 0 0 1 14 7.5Z" fill="white"></path> </svg>&nbsp;&nbsp;Generate</button>
                </div>
                <div>
                    <span id="openai-image-response"></span>
                </div>
            </fieldset>
        </div>
        <div class="aiomatic-footer">
        </div>
    </figure>
</div>
`;
    if(jQuery('body .media-modal-content .media-frame-content')[0] !== undefined)
    {
        jQuery('body .media-modal-content .media-frame-content').html(html);
    }
    else
    {
        if(jQuery('.aiomatic-image-tab-1')[0] !== undefined)
        {
            jQuery('.aiomatic-image-tab-1').html(html);
        }
    }
}
jQuery(document).ready(function() 
{
    jQuery(document).on('click',".aiomatic_ai_image_response_royalty",function () 
    {
        if (jQuery(this).hasClass("selectable")) 
        {
            jQuery('.thumbnail').removeClass('aiomaticselected');
            jQuery(this).addClass('aiomaticselected');
            selectedImage = jQuery(this).attr('src');
            jQuery('#aiomatic_image_upload_royalty').prop('disabled', false);
        }
    });
});
function aiomaticCapitalizeFirstLetter(string) 
{
    return string.charAt(0).toUpperCase() + string.slice(1);
}
function AiomaticDoMyTabRoyaltyContent() 
{
    if(aiomatic_img_ajax_object.royalty_free_sources.length > 0)
    {
        var aimodels = '';
        aiomatic_img_ajax_object.royalty_free_sources.forEach(async (imgsource) => 
        {
            aimodels += '<option value="' + imgsource + '">' + aiomaticCapitalizeFirstLetter(imgsource) + '</option>';
        });
    }
    else
    {
        var aimodels = '<option disabled value="no_source" selected>No royalty free sources enabled</option>';
    }
    var html = `
<style>.aiomaticselected {
border: 3px solid blue;
}
</style>
<div id="aiomatic-block-editor-royalty" class="aiomatic-block-editor">
    <figure class="block-editor-block-list__block wp-block is-selected wp-block-uploads-aiomatic" style="display: block;margin-block-start: 1em;margin-block-end: 1em;margin-inline-start: 40px;margin-inline-end: 40px;width:auto;max-width:100%">
        <div>
            <fieldset>
                <h4>Search for royalty free images, based on your options:</h4>
                <div class="aiomatic-image-result cr_image_center" id="aiomatic_image_div_royalty"></div>
                <div class="aiomatic-image-div" id="aiomatic-image-upload-royalty" style="display:none;">
                    <button type="button" id="aiomatic_image_upload_royalty" class="button load-more button-primary" onclick="aiomatic_upload_images_royalty();" disabled><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true" focusable="false"><path d="M18.5 15v3.5H13V6.7l4.5 4.1 1-1.1-6.2-5.8-5.8 5.8 1 1.1 4-4v11.7h-6V15H4v5h16v-5z"></path></svg>&nbsp;Save to Media Library</button>
                    <br/><br/>
                </div>
                <div class="aiomatic-prompt-form">
                    <label for="aiomatic-textarea-control-royalty">Search Keyword: enter a search keyword for which, royalty free images should be searched.</label>
                    <textarea style="width:100%;max-width:100%" id="aiomatic-textarea-control-royalty" rows="2" maxlength="450" placeholder="Your image keyword here"></textarea>
                </div>
                    <div>
                        <label for="aiomatic-ai-modifier">Select Image Source</label>
                    </div>
                    <div>
                        <select id="aiomatic-ai-modifier-royalty" style="width:100%;max-width:100%">` + aimodels + `</select>
                    </div>
                </div>
                <br/>
                <div>
                    <button type="button" id="aiomatic_image_get_royalty" class="button load-more button-primary" onclick="aiomatic_go_get_free_images();"><svg style="color: white" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-robot" viewBox="0 0 16 16"> <path d="M6 12.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5ZM3 8.062C3 6.76 4.235 5.765 5.53 5.886a26.58 26.58 0 0 0 4.94 0C11.765 5.765 13 6.76 13 8.062v1.157a.933.933 0 0 1-.765.935c-.845.147-2.34.346-4.235.346-1.895 0-3.39-.2-4.235-.346A.933.933 0 0 1 3 9.219V8.062Zm4.542-.827a.25.25 0 0 0-.217.068l-.92.9a24.767 24.767 0 0 1-1.871-.183.25.25 0 0 0-.068.495c.55.076 1.232.149 2.02.193a.25.25 0 0 0 .189-.071l.754-.736.847 1.71a.25.25 0 0 0 .404.062l.932-.97a25.286 25.286 0 0 0 1.922-.188.25.25 0 0 0-.068-.495c-.538.074-1.207.145-1.98.189a.25.25 0 0 0-.166.076l-.754.785-.842-1.7a.25.25 0 0 0-.182-.135Z" fill="white"></path> <path d="M8.5 1.866a1 1 0 1 0-1 0V3h-2A4.5 4.5 0 0 0 1 7.5V8a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1v1a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-1a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1v-.5A4.5 4.5 0 0 0 10.5 3h-2V1.866ZM14 7.5V13a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V7.5A3.5 3.5 0 0 1 5.5 4h5A3.5 3.5 0 0 1 14 7.5Z" fill="white"></path> </svg>&nbsp;&nbsp;Search</button>
                </div>
                <div>
                    <span id="openai-image-response-royalty"></span>
                </div>
            </fieldset>
        </div>
        <div class="aiomatic-footer">
        </div>
    </figure>
</div>
`;
    if(jQuery('body .media-modal-content .media-frame-content')[0] !== undefined)
    {
        jQuery('body .media-modal-content .media-frame-content').html(html);
    }
    else
    {
        if(jQuery('.aiomatic-image-tab-2')[0] !== undefined)
        {
            jQuery('.aiomatic-image-tab-2').html(html);
        }
    }
}
function aiomatic_go_get_free_images()
{
    jQuery('#aiomatic_image_get_royalty').attr('disabled', true);
    jQuery('#aiomatic_image_upload_royalty').attr('disabled', true);
    var instructionx = jQuery('#aiomatic-textarea-control-royalty');
    var instruction = instructionx.val();
    var imgSource = jQuery('#aiomatic-ai-modifier-royalty').find(":selected").val();
    if(imgSource == 'no_source')
    {
        alert('You need to enable a royalty free image source from the plugin\'s \'Settings\' menu -> \'Royalty Free Images\' tab to use this functionality.');
        jQuery('#aiomatic_image_get_royalty').attr('disabled', false);
        return;
    }
    if(instruction == '')
    {
        alert('You need to enter a keyword to use this feature!');
        jQuery('#aiomatic_image_get_royalty').attr('disabled', false);
        return;
    }
    jQuery("#aiomatic-image-upload-royalty").hide();
    jQuery('#openai-image-response-royalty').html('<div class="automaticx-dual-ring"></div>');
    jQuery('#aiomatic_image_div_royalty').html('');
    jQuery.ajax({
        type: 'POST',
        url: aiomatic_img_ajax_object.ajax_url,
        data: {
            action: 'aiomatic_generate_royalty_free_image_ajax',
            instruction: instruction,
            nonce: aiomatic_img_ajax_object.nonce,
            image_source: imgSource
        },
        success: function(response) {
            if(typeof response === 'string' || response instanceof String)
            {
                try {
                    var responset = JSON.parse(response);
                    response = responset;
                } catch (error) {
                    console.error("An error occurred while parsing the JSON: " + error + ' Json: ' + response);
                }
            }
            if(response.status == 'success')
            {
                if(response.data == '')
                {
                    jQuery('#openai-image-response-royalty').html('<div class="text-primary" role="status">No image was returned. Please try using a different search keyword.</div>');
                    jQuery("#aiomatic-image-upload-royalty").hide();
                }
                else
                {
                    var cnt = 1;
                    response.data.forEach((imageURL) => 
                    {
                        jQuery('#aiomatic_image_div_royalty').append('<img class="thumbnail selectable aiomatic_ai_image_response_royalty" id="aiomatic_ai_image_response_royalty' + cnt + '" data-image-id="' + cnt + '" src="' + imageURL + '" />');
                        jQuery('#aiomatic_ai_image_response_royalty' + cnt).css({ 'max-width': '200px', 'width': '200px', 'max-height': '200px', 'height': '200px', 'padding': '5px' }); 
                        cnt++;
                    });
                    
                    jQuery("#aiomatic-image-upload-royalty").show();
                    jQuery('#openai-image-response-royalty').html('');
                }
            }
            else
            {
                if(typeof response.msg !== 'undefined')
                {
                    jQuery('#openai-image-response-royalty').html('<div class="text-primary highlight-text-fail" role="status">' + response.msg + '</div>');
                }
                else
                {
                    console.log('Error: ' + response);
                    jQuery('#openai-image-response-royalty').html('<div class="text-primary highlight-text-fail" role="status">Processing failed, please try again</div>');
                }
                jQuery("#aiomatic-image-upload-royalty").hide();
            }
            jQuery('#aiomatic_image_get_royalty').attr('disabled', false);
        },
        error: function(error) {
            console.log('Error: ' + error.responseText);
            jQuery("#aiomatic-image-upload-royalty").hide();
            jQuery('#openai-image-response-royalty').html('<div class="text-primary highlight-text-fail" role="status">Failed to search for a royalty free image, try again later.</div>');
            jQuery('#aiomatic_image_get_royalty').attr('disabled', false);
        },
    });
}
function aiomatic_go_get_images()
{
    jQuery('#aiomatic_image_get').attr('disabled', true);
    jQuery('#aiomatic_image_upload').attr('disabled', true);
    var instructionx = jQuery('#aiomatic-textarea-control');
    var instruction = instructionx.val();
    var imageStyle = jQuery('#aiomatic-image-style').find(":selected").val();
    if(imageStyle != '')
    {
        instruction += ' ' + imageStyle;
    }
    var artistStyle = jQuery('#aiomatic-artist-style').find(":selected").val();
    if(artistStyle != '')
    {
        instruction += ' ' + artistStyle;
    }
    var styleModifier = jQuery('#aiomatic-style-modifier').find(":selected").val();
    if(styleModifier != '')
    {
        instruction += ' ' + styleModifier;
    }
    var photoModifier = jQuery('#aiomatic-photography-modifier').find(":selected").val();
    if(photoModifier != '')
    {
        instruction += ' ' + photoModifier + '.';
    }
    var lightingModifier = jQuery('#aiomatic-lighting-modifier').find(":selected").val();
    if(lightingModifier != '')
    {
        instruction += ' ' + lightingModifier + '.';
    }
    var subjectModifier = jQuery('#aiomatic-subject-modifier').find(":selected").val();
    if(subjectModifier != '')
    {
        instruction += ' ' + subjectModifier + '.';
    }
    var cameraModifier = jQuery('#aiomatic-camera-modifier').find(":selected").val();
    if(cameraModifier != '')
    {
        instruction += ' ' + cameraModifier + '.';
    }
    var compositionModifier = jQuery('#aiomatic-composition-modifier').find(":selected").val();
    if(compositionModifier != '')
    {
        instruction += ' ' + compositionModifier + '.';
    }
    var resolutionModifier = jQuery('#aiomatic-resolution-modifier').find(":selected").val();
    if(resolutionModifier != '')
    {
        instruction += ' ' + resolutionModifier + '.';
    }
    var colorModifier = jQuery('#aiomatic-color-modifier').find(":selected").val();
    if(colorModifier != '')
    {
        instruction += ' ' + colorModifier + '.';
    }
    var effectsModifier = jQuery('#aiomatic-effects-modifier').find(":selected").val();
    if(effectsModifier != '')
    {
        instruction += ' ' + effectsModifier + '.';
    }
    var aiModel = jQuery('#aiomatic-ai-modifier').find(":selected").val();
    if(aiModel == 'openai')
    {
        aiModel = 'dalle2';
    }
    if(instruction == '')
    {
        alert('You need to enter a prompt or select a value from the image style settings!');
        jQuery('#aiomatic_image_get').attr('disabled', false);
        jQuery('#aiomatic_image_upload').attr('disabled', false);
        return;
    }
    var image_sizex = jQuery('#aiomatic-size-modifier');
    var image_size = image_sizex.val();
    if(aiModel == 'dalle2')
    {
        if(image_size != '256x256' && image_size != '512x512' && image_size != '1024x1024')
        {
            image_size = '256x256';
        }
    }
    else
    {
        if(aiModel == 'midjourney')
        {
            if(image_size != '512x512' && image_size != '1024x1024' && image_size != '1792x1024' && image_size != '1024x1792')
            {
                image_size = '1024x1024';
            }
        }
        else
        {
            if(image_size != '1024x1024' && image_size != '1792x1024' && image_size != '1024x1792')
            {
                image_size = '1024x1024';
            }
        }
    }
    var image_placeholder = aiomatic_img_ajax_object.image_placeholder;
    jQuery("#aiomatic_ai_image_response").attr("src", image_placeholder).fadeIn();
    jQuery("#aiomatic-image-upload").hide();
    jQuery('#openai-image-response').html('<div class="automaticx-dual-ring"></div>');
    jQuery.ajax({
        type: 'POST',
        url: aiomatic_img_ajax_object.ajax_url,
        data: {
            action: 'aiomatic_generate_image_ajax',
            instruction: instruction,
            image_size: image_size,
            user_token_cap_per_day: '',
            nonce: aiomatic_img_ajax_object.nonce,
            user_id: '',
            ai_model: aiModel
        },
        success: function(response) {
            if(typeof response === 'string' || response instanceof String)
            {
                try {
                    var responset = JSON.parse(response);
                    response = responset;
                } catch (error) {
                    console.error("An error occurred while parsing the JSON: " + error + ' Json: ' + response);
                }
            }
            if(response.status == 'success')
            {
                if(response.data == '')
                {
                    jQuery('#openai-image-response').html('<div class="text-primary" role="status">No image was returned. Please try using a different text input.</div>');
                    jQuery("#aiomatic_ai_image_response").attr("src", '').fadeIn();
                    jQuery("#aiomatic-image-upload").hide();
                }
                else
                {
                    if(aiModel == 'stable')
                    {
                        jQuery("#aiomatic_ai_image_response").attr("src", "data:image/png;base64," + response.data).fadeIn();
                    }
                    else
                    {
                        jQuery("#aiomatic_ai_image_response").attr("src", response.data).fadeIn();
                    }
                    jQuery("#aiomatic-image-upload").show();
                    jQuery('#openai-image-response').html('');
                }
            }
            else
            {
                if(typeof response.msg !== 'undefined')
                {
                    jQuery('#openai-image-response').html('<div class="text-primary highlight-text-fail" role="status">' + response.msg + '</div>');
                }
                else
                {
                    console.log('Error: ' + response);
                    jQuery('#openai-image-response').html('<div class="text-primary highlight-text-fail" role="status">Processing failed, please try again</div>');
                }
                jQuery("#aiomatic_ai_image_response").attr("src", '').fadeIn();
                jQuery("#aiomatic-image-upload").hide();
            }
            jQuery('#aiomatic_image_get').attr('disabled', false);
            jQuery('#aiomatic_image_upload').attr('disabled', false);
        },
        error: function(error) {
            console.log('Error: ' + error.responseText);
            jQuery("#aiomatic_ai_image_response").attr("src", '').fadeIn();
            jQuery("#aiomatic-image-upload").hide();
            jQuery('#openai-image-response').html('<div class="text-primary highlight-text-fail" role="status">Failed to generate image content, try again later.</div>');
            jQuery('#aiomatic_image_get').attr('disabled', false);
            jQuery('#aiomatic_image_upload').attr('disabled', false);
        },
    });
}
function aiomatic_upload_images_royalty()
{
    jQuery('#aiomatic_image_get_royalty').attr('disabled', true);
    jQuery('#aiomatic_image_upload_royalty').attr('disabled', true);
    if(selectedImage == '')
    {
        alert('You need to select an image first!');
        jQuery('#aiomatic_image_get_royalty').attr('disabled', false);
        jQuery('#aiomatic_image_upload_royalty').attr('disabled', false);
        return;
    }
    var instructionx = jQuery('#aiomatic-textarea-control');
    var instruction = instructionx.val();
    var postId;
    if (wp && wp.data) {
        postId = wp.data.select('core/editor').getCurrentPostId();
    } else {
        postId = aiomatic_img_ajax_object.postId;
    }
    jQuery('#openai-image-response-royalty').html('<div class="automaticx-dual-ring"></div>');
    jQuery.ajax({
        type: 'POST',
        url: aiomatic_img_ajax_object.ajax_url,
        data: {
            action: 'aiomatic_save_image',
            imagesrc: selectedImage,
            orig_prompt: instruction,
            post_id: postId,
            nonce: aiomatic_img_ajax_object.nonce
        },
        success: function(response) {
            if(response.success !== true)
            {
                alert('Failed to copy image to the Media Library, please try again later.')
            }
            else
            {
                jQuery('#openai-image-response-royalty').html('Image uploaded successfully, check your Media Library!');
            }
            jQuery('#aiomatic_image_get_royalty').attr('disabled', false);
            jQuery('#aiomatic_image_upload_royalty').attr('disabled', false);
            if ( wp.media.frame !== undefined && wp.media.frame.content.get() ) 
            {
                wp.media.frame.content.get().collection._requery( true );
            }
        },
        error: function(error) {
            console.log('Error during image upload: ' + error.responseText);
            jQuery('#openai-image-response-royalty').html('<div class="text-primary highlight-text-fail" role="status">Failed to upload image, try again later.</div>');
            jQuery('#aiomatic_image_get_royalty').attr('disabled', false);
            jQuery('#aiomatic_image_upload_royalty').attr('disabled', false);
        },
    });
}
function aiomatic_upload_images()
{
    jQuery('#aiomatic_image_get').attr('disabled', true);
    jQuery('#aiomatic_image_upload').attr('disabled', true);
    var imagesrc = jQuery('#aiomatic_ai_image_response').attr('src');
    if(imagesrc == '')
    {
        alert('You need to create an image first!');
        jQuery('#aiomatic_image_get').attr('disabled', false);
        jQuery('#aiomatic_image_upload').attr('disabled', false);
        return;
    }
    var instructionx = jQuery('#aiomatic-textarea-control');
    var instruction = instructionx.val();
    var imageStyle = jQuery('#aiomatic-image-style').find(":selected").val();
    if(imageStyle != '')
    {
        instruction += ' ' + imageStyle;
    }
    var artistStyle = jQuery('#aiomatic-artist-style').find(":selected").val();
    if(artistStyle != '')
    {
        instruction += ' ' + artistStyle;
    }
    var styleModifier = jQuery('#aiomatic-style-modifier').find(":selected").val();
    if(styleModifier != '')
    {
        instruction += ' ' + styleModifier;
    }
    var photoModifier = jQuery('#aiomatic-photography-modifier').find(":selected").val();
    if(photoModifier != '')
    {
        instruction += ' ' + photoModifier + '.';
    }
    var lightingModifier = jQuery('#aiomatic-lighting-modifier').find(":selected").val();
    if(lightingModifier != '')
    {
        instruction += ' ' + lightingModifier + '.';
    }
    var subjectModifier = jQuery('#aiomatic-subject-modifier').find(":selected").val();
    if(subjectModifier != '')
    {
        instruction += ' ' + subjectModifier + '.';
    }
    var cameraModifier = jQuery('#aiomatic-camera-modifier').find(":selected").val();
    if(cameraModifier != '')
    {
        instruction += ' ' + cameraModifier + '.';
    }
    var compositionModifier = jQuery('#aiomatic-composition-modifier').find(":selected").val();
    if(compositionModifier != '')
    {
        instruction += ' ' + compositionModifier + '.';
    }
    var resolutionModifier = jQuery('#aiomatic-resolution-modifier').find(":selected").val();
    if(resolutionModifier != '')
    {
        instruction += ' ' + resolutionModifier + '.';
    }
    var colorModifier = jQuery('#aiomatic-color-modifier').find(":selected").val();
    if(colorModifier != '')
    {
        instruction += ' ' + colorModifier + '.';
    }
    var effectsModifier = jQuery('#aiomatic-effects-modifier').find(":selected").val();
    if(effectsModifier != '')
    {
        instruction += ' ' + effectsModifier + '.';
    }
    var postId;
    if (wp && wp.data) {
        postId = wp.data.select('core/editor').getCurrentPostId();
    } else {
        postId = aiomatic_img_ajax_object.postId;
    }
    jQuery('#openai-image-response').html('<div class="automaticx-dual-ring"></div>');
    jQuery.ajax({
        type: 'POST',
        url: aiomatic_img_ajax_object.ajax_url,
        data: {
            action: 'aiomatic_save_image',
            imagesrc: imagesrc,
            orig_prompt: instruction,
            post_id: postId,
            nonce: aiomatic_img_ajax_object.nonce
        },
        success: function(response) {
            if(response.success !== true)
            {
                alert('Failed to copy image to the Media Library, please try again later.')
            }
            else
            {
                jQuery('#openai-image-response').html('Image uploaded successfully, check your Media Library!');
            }
            jQuery('#aiomatic_image_get').attr('disabled', false);
            jQuery('#aiomatic_image_upload').attr('disabled', false);
            if ( wp.media.frame !== undefined && wp.media.frame.content.get() ) 
            {
                wp.media.frame.content.get().collection._requery( true );
            }
        },
        error: function(error) {
            console.log('Error during image upload: ' + error.responseText);
            jQuery('#openai-image-response').html('<div class="text-primary highlight-text-fail" role="status">Failed to upload image, try again later.</div>');
            jQuery('#aiomatic_image_get').attr('disabled', false);
            jQuery('#aiomatic_image_upload').attr('disabled', false);
        },
    });
}
function aiomaticModelChanged()
{
    var styleModifier = jQuery('#aiomatic-ai-modifier').find(":selected").val();
    if(styleModifier == 'stable')
    {
        jQuery("#aiomatic-size-modifier option[value='1792x1024']").remove();
        jQuery("#aiomatic-size-modifier option[value='1024x1792']").remove();
        jQuery("#aiomatic-size-modifier option[value='256x256']").remove();
        if(jQuery("#aiomatic-size-modifier option[value='512x512']").length == 0)
        {
            jQuery('#aiomatic-size-modifier').append(jQuery('<option>', { 
                value: '512x512',
                text : '512x512' 
            }));
        }
    }
    else 
    {
        if(styleModifier == 'openai')
        {
            jQuery("#aiomatic-size-modifier option[value='1792x1024']").remove();
            jQuery("#aiomatic-size-modifier option[value='1024x1792']").remove();
            if(jQuery("#aiomatic-size-modifier option[value='256x256']").length == 0)
            {
                jQuery('#aiomatic-size-modifier').append(jQuery('<option>', { 
                    value: '256x256',
                    text : '256x256' 
                }));
            }
            if(jQuery("#aiomatic-size-modifier option[value='512x512']").length == 0)
            {
                jQuery('#aiomatic-size-modifier').append(jQuery('<option>', { 
                    value: '512x512',
                    text : '512x512' 
                }));
            }
        }
        else if(styleModifier == 'dalle3' || styleModifier == 'dalle3hd')
        {
            jQuery("#aiomatic-size-modifier option[value='256x256']").remove();
            jQuery("#aiomatic-size-modifier option[value='512x512']").remove();
            if(jQuery("#aiomatic-size-modifier option[value='1792x1024']").length == 0)
            {
                jQuery('#aiomatic-size-modifier').append(jQuery('<option>', { 
                    value: '1792x1024',
                    text : '1792x1024' 
                }));
            }
            if(jQuery("#aiomatic-size-modifier option[value='1024x1792']").length == 0)
            {
                jQuery('#aiomatic-size-modifier').append(jQuery('<option>', { 
                    value: '1024x1792',
                    text : '1024x1792' 
                }));
            }
        }
    }
}