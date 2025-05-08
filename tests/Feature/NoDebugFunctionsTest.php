<?php

it('does not use debug functions')->expect(['dd','dump','ray','debug'])->not->toBeUsed();

