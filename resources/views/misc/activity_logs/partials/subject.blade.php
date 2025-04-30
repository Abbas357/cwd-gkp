@php
    $subjectDetails = $subjectId; 
    $subjectLink = null;

    if (class_exists($subjectType)) {
        $subject = (new $subjectType)->find($subjectId);

        if ($subject) {
            $subjectClassName = strtolower(class_basename($subjectType));

            if (class_basename($subjectType) === 'Contractor') {
                $routeName = 'admin.contractors.show';
            } elseif (class_basename($subjectType) === 'Standardization') {
                $routeName = 'admin.standardizations.show';
            } elseif (class_basename($subjectType) === 'Story') {
                $routeName = 'admin.stories.show';
            }elseif (class_basename($subjectType) === 'Gallery') {
                $routeName = 'admin.gallery.show';
            } else {
                $routeName = 'admin.' . $subjectClassName . 's.show';
            }

            if (Route::has($routeName)) {
                $subjectLink = route($routeName, $subjectId);
            }
        }
    }
@endphp

@if ($subject && $subjectLink)
    <a href="{{ $subjectLink }}">View</a>
@else
    {{ $subjectDetails }}
@endif
