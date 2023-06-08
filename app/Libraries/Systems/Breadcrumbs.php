<?php

namespace App\Libraries\Systems;

class Breadcrumbs
{

   private $breadcrumbs = array();
   private $tags;
   private $URI;
   private $clickable;
   public $Config;

   /**
    * Constructor function to initialize breadcrumb tags based on the given framework.
    */
   public function __construct()
   {
      // Load the URI class
      $this->URI = service('uri');

      // SHOULD THE LAST BREADCRUMB BE A CLICKABLE LINK? If SO SET TO TRUE
      $this->clickable = false;

      // create our bootstrap html elements
      $this->tags['navopen']  = "";
      $this->tags['navclose'] = "";
      $this->tags['olopen']   = "<ol class='breadcrumb text-muted fs-8 fw-semibold'>";
      $this->tags['olclose']  = "</ol>";
      $this->tags['liopen']   = "<li class='breadcrumb-item pe-1'>";
      $this->tags['liclose']  = "</li>";
   }


   /**
    * Adds a breadcrumb to the list of breadcrumbs.
    *
    * @param string $crumb The text for the breadcrumb.
    * @param string $href The URL for the breadcrumb.
    */
   public function add(string $crumb, string $href)
   {
      if (!$crumb || !$href) {
         // If either the title or href is not set, return without adding the breadcrumb.
         return;
      }

      $this->breadcrumbs[] = [
         'crumb' => $crumb,
         'href' => $href,
      ];
   }

   /**
    * Renders the breadcrumbs as HTML.
    *
    * @return string The HTML for the breadcrumb.
    */
   public function render()
   {
      // Initialize the output with the opening tags for the navigation and list elements
      $output  = $this->tags['navopen'];
      $output .= $this->tags['olopen'];

      // Determine the number of breadcrumbs in the array
      $count = count($this->breadcrumbs) - 1;

      // Iterate through each breadcrumb and add it to the output
      foreach ($this->breadcrumbs as $index => $breadcrumb) {
         // If this is the last breadcrumb in the array, don't include a link
         if ($index == $count) {
            $output .= $this->tags['liopen'];
            $output .= $breadcrumb['crumb'];
            $output .= $this->tags['liclose'];
         }
         // For all other breadcrumbs, include a link
         else {
            $output .= $this->tags['liopen'];
            // Use the site_url() function instead of base_url() for better security
            $output .= '<a href="' . site_url($breadcrumb['href']) . '">';
            $output .= $breadcrumb['crumb'];
            $output .= '</a>';
            $output .= $this->tags['liclose'];
         }
      }

      // Close the list and navigation elements
      $output .= $this->tags['olclose'];
      $output .= $this->tags['navclose'];

      return $output;
   }

   /**
    * Builds the breadcrumb automatically based on the current URI.
    *
    * @return string The HTML for the breadcrumb.
    */
   public function buildAuto()
   {
      $urisegments = $this->URI->getSegments();

      $output  = $this->tags['navopen'];
      $output .= $this->tags['olopen'];

      $crumbs = array_filter($urisegments);

      $result = array();
      $path = '';

      // SUBTRACT 1 FROM COUNT IF THE LAST LINK IS TO NOT BE A LINK
      $count = count($crumbs);

      if (!$this->clickable) {
         $count--;
      }

      foreach ($crumbs as $k => $crumb) {
         $path .= '/' . $crumb;
         $name = ucwords(str_replace(array(".php", "_"), array("", " "), $crumb));
         $name = ucwords(str_replace('-', ' ', $name));

         if ($k !== $count && $k !== 0) {
            $result[] = $this->tags['liopen'] . '<a href="' . $path . '">' . $name . '</a>&nbsp' . $this->tags['liclose'];
         } else {
            $result[] = $this->tags['liopen'] . $name . '&nbsp;' . $this->tags['liclose'];
         }
      }

      $output .= implode($result);
      $output .= $this->tags['olclose'];
      $output .= $this->tags['navclose'];

      return $output;
   }
}
