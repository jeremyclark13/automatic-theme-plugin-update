<?php
require_once('packages.php');
// This is the folder where all update files are stored
$update_folder = './update/';

if ( isset( $_GET['key'] ) ) {
    // loop over all the theme and plugin arrays
    foreach ( $packages as $package ) {
        // loop over all the versions for each theme and plugin
        foreach ( $package['versions'] as $version ) {
            // md5 timestamp of current and previous day and the file name
            $tod_md5 = md5( $version['file_name'] . mktime( 0, 0, 0, date( "m" ), date( "d" ), date( "Y" ) ) );
            $yes_md5 = md5( $version['file_name'] . mktime( 0, 0, 0, date( "m" ), date( "d" ) - 1, date( "Y" ) ) );
            // test if the either of the md5 hashes match what was passed
            if ( $_GET['key'] == $tod_md5 || $_GET['key'] == $yes_md5 ) {
                $download = $update_folder . $version['file_name'];
                if ( file_exists( $download ) ) {
                    //get the file content
                    $file = file_get_contents( $download );

                    //set the headers to force a download
                    header( "Content-type: application/force-download" );
                    header( "Content-Disposition: attachment; filename=\"" . str_replace( " ", "_", $version['file_name'] ) . "\"" );

                    //echo the file to the user
                    echo $file;
                }
            }
        }
    }
}
?>