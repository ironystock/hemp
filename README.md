# HEMP
*Hypermedia-Enabled Minimalst Patchwork*

HEMP is a collection of developer-focused, [HTMX](https://htmx.org/ "HTMX; high power tools for HTML")-first tools for *AMP developers and teams that can be connected together into a patchwork (**not** a _framework_) to assist, out of the box, in prototyping or ideating modern web apps using [HATEOAS](https://htmx.org/essays/hateoas/ "Hypermedia as the Engine of Application State") as a guiding principle. 

HEMP is built with a bottom-up approach that allows pieces and parts of this patchwork to be integrated cleanly within other projects or environments either as a signpost, placeholder or even production element. As such, HEMP is licensed under the MIT License.

Although my daily-driver database and server are what I've chosen to use as a build-around, I've included interfaces for anyone to extend the same functionality to whatever needs may exist. I hope to build more examples and happily await any pull requests anyone might come up with that make sense.

## Design Core Values
- Least-required-lines; nobody likes Tolstoy-code
- Hypermedia anywhere it makes sense, and some where it doesn't; lean into the core tenets of HTMX, both technique through principle
- No-feature-required, only core; configless works out of box
- Use the vernacular you're building in; HTTP and HTML are the languages we're trying to implement, we should use that paradigm in our project
- Style is personal; we may ship extras, examples or even features that leverage CSS, but we never hoist it
- Static easier than dynamic; we should assist development not work against HTTP or established norms
- DX before UX; we're building to make developing 

